<?php

declare(strict_types=1);

/**
 * public/index.php
 * СТАНДАРТ V86 — CENTRAL ROUTER & WORKER
 * Обновлено: добавлены маршруты для тегов и исправлены потерянные маршруты (22.04.2026)
 * Обновлено: исправлен порядок загрузки, .env через vlucas/phpdotenv, убран die() (29.06.2026)
 */

define('ROOT_PATH', dirname(__DIR__));

// 1. Подключение автозагрузчика Composer (первым — до всего остального)
require_once ROOT_PATH . '/vendor/autoload.php';

// 2. Загрузка переменных окружения через vlucas/phpdotenv
if (file_exists(ROOT_PATH . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
    $dotenv->load();
}
// 2а. Секреты входа в админку — отдельный файл (.env.auth), который docker compose
// не читает и не интерполирует. Иначе $ в bcrypt-хэше давал варнинги compose.
if (file_exists(ROOT_PATH . '/.env.auth')) {
    $dotenvAuth = Dotenv\Dotenv::createImmutable(ROOT_PATH, '.env.auth');
    $dotenvAuth->load();
}

// 2б. Boot ядра nws-core: константа NWS_CORE, классы+хелперы, конфиг-слой сайта
// (дефолты ядра + site.config.php; пути хранилища; глобальные хелперы)
try {
    require_once ROOT_PATH . '/nws-core/bootstrap.php';
    nws_boot(ROOT_PATH, ROOT_PATH . '/site.config.php');
} catch (\Throwable $e) {
    http_response_code(500);
    echo "Критична помилка ядра: " . $e->getMessage();
    exit;
}

// 3. Старт сессии
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Forced Reset: Переключаем старые сессии 'ua' на 'uk'
if (($_SESSION['lang'] ?? '') === 'ua') {
    $_SESSION['lang'] = 'uk';
}

// 4. Подключение ядра (тяжёлый хелпер нарезки изображений — отдельно)
try {
    if (file_exists(NWS_CORE . '/App/includes/generate_img.php')) {
        require_once NWS_CORE . '/App/includes/generate_img.php';
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo "Критична помилка ядра: " . $e->getMessage();
    exit;
}

/**
 * Логика обработки запроса
 */
$handler = static function () {
    $uri = (string)parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    // Защита от статики (динамические SEO-маршруты /sitemap.xml и /robots.txt — исключение)
    if ($uri !== '/' && str_contains($uri, '.') && !in_array($uri, ['/sitemap.xml', '/robots.txt'], true)) {
        if (!file_exists(__DIR__ . $uri)) {
            // SEO Seamless Redirect: vykrojki_YEAR -> vykrojki-YEAR
            if (str_contains($uri, 'vykrojki_')) {
                $newUri = preg_replace('~vykrojki_(\d{4})~', 'vykrojki-$1', $uri);
                if ($newUri !== $uri && file_exists(__DIR__ . $newUri)) {
                    header("Location: $newUri", true, 301);
                    return;
                }
            }
            header('Content-Type: text/plain');
            http_response_code(404);
            echo "404 Not Found: Static resource missing";
            return;
        }
    }

    try {
        if (ob_get_level() > 0) ob_clean();

        // 1. Обработка префикса языка
        $cleanUri = $uri;
        $allowedLangs = config('site.langs');

        $request_uri_raw = $_SERVER['REQUEST_URI'];
        $langFlags = array_diff(config('site.langs'), [config('site.default_lang', 'uk')]);
        $cleanPath = preg_replace('/^\/(?:' . implode('|', $langFlags) . ')(\/|$)/', '/', $request_uri_raw);
        $cleanPath = str_replace('//', '/', $cleanPath);
        if (empty($cleanPath) || $cleanPath === '') $cleanPath = '/';
        define('CURRENT_URI', $cleanPath);

        if (preg_match('~^/([a-z]{2})(/|$)~', $uri, $matches)) {
            $detectedLang = $matches[1];
            if (in_array($detectedLang, $allowedLangs)) {
                $_SESSION['lang'] = $detectedLang;
                $cleanUri = preg_replace('~^/' . $detectedLang . '~', '', $uri);
                if (empty($cleanUri)) $cleanUri = '/';
            } else {
                $_SESSION['lang'] = 'uk';
            }
        } else {
            $_SESSION['lang'] = 'uk';
        }

        if (empty($_SESSION['lang'])) {
            $_SESSION['lang'] = 'uk';
        }

        ob_start();
        $router = new \App\Core\Router();

        // --- PUBLIC ROUTES ---
        $router->get('/', 'ArticleController@index');
        $router->get('/sitemap.xml', 'SeoController@sitemap');
        $router->get('/robots.txt', 'SeoController@robots');
        $router->get('/lang/{code}', function (string $code) {
            $code = strtolower($code);
            if ($code === 'ua') $code = 'uk';
            if (in_array($code, config('site.langs'))) {
                $_SESSION['lang'] = $code;
            }
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        });

        $router->get('/search', 'ArticleController@search');
        // SHOP ВРЕМЕННО ОТКЛЮЧЕН (Фаза 1 — запуск сайта без магазина). Ничего не удалено, данные и файлы товаров сохранены.
        // $router->get('/shop/product/{slug}-{id}', 'ShopController@view');
        $router->get('/download/{slug}-{id}', 'DownloadController@show');
        $router->get('/download/{slug}-{id}/confirm', 'DownloadController@deliver');
        $router->get('/tag/{slug}', 'ArticleController@tag');

        // --- ADMIN ROUTES ---
        // 1. Авторизация
        $router->get(admin_url(), 'Adm\Controllers\AuthController@showLogin');
        $router->post(admin_url('/auth/login'), 'Adm\Controllers\AuthController@login');
        $router->get(admin_url('/auth/verify'), 'Adm\Controllers\AuthController@showVerify');
        $router->post(admin_url('/auth/verify'), 'Adm\Controllers\AuthController@verify');

        // 2. Статьи: Список и Категории
        $router->get(admin_url('/articles'), 'Adm\Controllers\ArticleController@index');
        $router->get(admin_url('/hubs/get-children'), 'Adm\Controllers\ArticleController@getHubChildren');
        $router->post(admin_url('/tags/add'), 'Adm\Controllers\ArticleController@addTag');

        // 3. Статьи: Создание и Сохранение
        $router->get(admin_url('/articles/create'), 'Adm\Controllers\ArticleController@create');
        $router->post(admin_url('/articles/create'), 'Adm\Controllers\ArticleController@create');
        $router->post(admin_url('/articles/store'), 'Adm\Controllers\ArticleController@create');

        // 4. Статьи: Редактирование и Обновление
        $router->get(admin_url('/articles/edit/{id}'), 'Adm\Controllers\ArticleController@edit');
        $router->post(admin_url('/articles/update/{id}'), 'Adm\Controllers\ArticleController@update');

        // 5. Маршруты для сплит-системы (HTMX)
        $router->post(admin_url('/articles/init-shop/{id}'), 'Adm\Controllers\ArticleController@initShop');

        // 6. SHOP MODULE (HTMX)
        $router->get(admin_url('/shop/edit-fields/{id}'), 'Adm\Controllers\ShopController@editFields');
        $router->post(admin_url('/shop/scan/{id}'), 'Adm\Controllers\ShopController@scan');

        // 7. Управление состоянием (HTMX)
        $router->post(admin_url('/articles/toggle-status/{id}'), 'Adm\Controllers\ArticleController@toggleStatus');
        $router->delete(admin_url('/articles/delete/{id}'), 'Adm\Controllers\ArticleController@delete');

        // 8. Загрузка файлов
        $router->post(admin_url('/upload/image/{id}'), 'Adm\Controllers\ArticleController@uploadImage');
        $router->post(admin_url('/upload/pdf/{id}'), 'Adm\Controllers\ArticleController@uploadPdf');
        $router->post(admin_url('/upload/zip/{id}'), 'Adm\Controllers\ArticleController@uploadZip');

        // --- LEGACY URL MIGRATION (SEO Этап 4): старые category/gender/page прода -> хабы v85 ---
        // До динамических маршрутов: старые пути иначе не матчатся (404) или падают в фоллбек.
        $router->get('/category/{slug}', 'SeoController@category');
        $router->get('/category/{slug}/page/{page}', 'SeoController@category');
        $router->get('/gender/{slug}', 'SeoController@gender');
        $router->get('/gender/{slug}/page/{page}', 'SeoController@gender');
        $router->get('/page/{page}', 'SeoController@homepage');

        // --- DYNAMIC CONTENT ROUTES ---
        $router->get('/{hub_slug}/{unit_slug}-{unit_id}', 'ArticleController@view');
        $router->get('/{hub_slug}/-{unit_id}', 'ArticleController@view'); // Фоллбек для пустого слага
        $router->get('/article/{unit_slug}-{unit_id}', 'ArticleController@view'); // Фоллбек без хаба
        $router->get('/{hub_slug}', 'ArticleController@hub');

        // ЗАПУСК РОУТЕРА
        $router->dispatch($cleanUri, $requestMethod);

        if (ob_get_level() > 0) ob_end_flush();
    } catch (\Throwable $e) {
        if (ob_get_level() > 0) ob_end_clean();
        http_response_code(500);
        echo "<h1>Помилка додатка</h1>";
        echo "<p><b>Повідомлення:</b> {$e->getMessage()}</p>";
        echo "<p><b>Файл:</b> {$e->getFile()} (Лінія: {$e->getLine()})</p>";
    }
};

// Запуск (FrankenPHP Worker Mode Support)
if (function_exists('frankenphp_handle_request') && (bool)getenv('FRANKENPHP_WORKER_MODE')) {
    frankenphp_handle_request($handler);
} else {
    $handler();
}