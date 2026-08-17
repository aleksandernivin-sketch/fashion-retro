<?php

declare(strict_types=1);
// app\includes\page_header_section.php

// Эти переменные ожидаются от вызывающего скрипта (например, index.php, category_page.php, gender_page.php, view_post.php)
// $base_url - базовый URL сайта
// $current_page_type - тип текущей страницы (например, 'index', 'category', 'gender', 'article')
// $page_header_title - текст для хлебных крошек (для index/category/gender это название страницы, для article это название родительского элемента)
// $page_header_slug - слаг для ссылки в хлебных крошках (используется для category/gender)
// $page - текущий номер страницы для пагинации (необязательно, для index/category/gender)

// ПЕРЕМЕННЫЕ ДЛЯ СТАТЕЙ (для многоуровневых хлебных крошек)
// $article_breadcrumb_parent_link - ссылка на родительскую категорию/гендер статьи
// $article_breadcrumb_parent_title - название родительской категории/гендера статьи
// $article_breadcrumb_sub_parent_link - ссылка на второй родительский элемент (например, gender)
// $article_breadcrumb_sub_parent_title - название второго родительского элемента (например, "Викрійки для дітей")

// Убедимся, что $base_url доступен (резервный вариант, должен быть установлен через link.php)
if (!isset($base_url)) {
    // ВНИМАНИЕ: Если config/link.php не существует или не определяет $base_url,
    // эту строку нужно будет изменить, или убедиться, что $base_url
    // определен перед подключением этого файла.
    require_once __DIR__ . "/../config/link.php";
}

// Устанавливаем значения по умолчанию, чтобы избежать ошибок, если переменные не установлены
$current_page_type = $current_page_type ?? "index";
$page_header_title = $page_header_title ?? "";
$page_header_slug = $page_header_slug ?? "";
$page = $page ?? 1;

// Для типа 'article' ожидаем дополнительные переменные
$article_breadcrumb_parent_link = $article_breadcrumb_parent_link ?? "";
$article_breadcrumb_parent_title = $article_breadcrumb_parent_title ?? "";
$article_breadcrumb_sub_parent_link = $article_breadcrumb_sub_parent_link ?? "";
$article_breadcrumb_sub_parent_title =
    $article_breadcrumb_sub_parent_title ?? "";

// Добавляем специфический класс на основе типа страницы для возможности индивидуального стилизования
$section_class =
    "section page-header-block " .
    htmlspecialchars((string) $current_page_type) .
    "-header-block";

echo '<section class="' . $section_class . '">';

echo '<div class="breadcrumbs">';

// Ссылка на главную страницу всегда первая
echo '<a href="' . htmlspecialchars((string) $base_url) . '/">Головна</a>';

// Логика формирования хлебных крошек
if (
    $current_page_type === "category" &&
    !empty($page_header_title) &&
    !empty($page_header_slug)
) {
    echo '<span class="breadcrumb-separator"> &gt; </span><a href="' .
        htmlspecialchars((string) $base_url) .
        "/category/" .
        htmlspecialchars((string) $page_header_slug) .
        '/">' .
        htmlspecialchars((string) $page_header_title) .
        "</a>";
} elseif (
    $current_page_type === "gender" &&
    !empty($page_header_title) &&
    !empty($page_header_slug)
) {
    echo '<span class="breadcrumb-separator"> &gt; </span><a href="' .
        htmlspecialchars((string) $base_url) .
        "/gender/" .
        htmlspecialchars((string) $page_header_slug) .
        '/">' .
        htmlspecialchars((string) $page_header_title) .
        "</a>";
} elseif ($current_page_type === "index" && !empty($page_header_title)) {
    // Если это не первая страница (т.е. есть пагинация), то "Статті" - это ссылка на первую страницу.
    // Если это первая страница, то "Статті" - это просто текст.
    if ($page > 1) {
        echo '<span class="breadcrumb-separator"> &gt; </span><a href="' .
            htmlspecialchars((string) $base_url) .
            '/">' .
            htmlspecialchars((string) $page_header_title) .
            "</a>";
    } else {
        echo '<span class="breadcrumb-separator"> &gt; </span><span>' .
            htmlspecialchars((string) $page_header_title) .
            "</span>";
    }
}
// УСЛОВИЕ ДЛЯ СТРАНИЦ СТАТЕЙ (article)
// Здесь выводим только родительские элементы, название самой статьи не включаем.
elseif ($current_page_type === "article") {
    // Если есть второй родительский элемент (например, gender)
    if (
        !empty($article_breadcrumb_sub_parent_link) &&
        !empty($article_breadcrumb_sub_parent_title)
    ) {
        echo '<span class="breadcrumb-separator"> &gt; </span><a href="' .
            htmlspecialchars((string) $article_breadcrumb_sub_parent_link) .
            '">' .
            htmlspecialchars((string) $article_breadcrumb_sub_parent_title) .
            "</a>";
    }
    // Если есть первый родительский элемент (категория/основной gender)
    // Добавляем проверку, чтобы не дублировать, если sub_parent_link и parent_link ведут на одну и ту же страницу.
    if (
        !empty($article_breadcrumb_parent_link) &&
        !empty($article_breadcrumb_parent_title) &&
        $article_breadcrumb_parent_link !== $article_breadcrumb_sub_parent_link
    ) {
        // Добавлена проверка на дублирование
        echo '<span class="breadcrumb-separator"> &gt; </span><a href="' .
            htmlspecialchars((string) $article_breadcrumb_parent_link) .
            '">' .
            htmlspecialchars((string) $article_breadcrumb_parent_title) .
            "</a>";
    }
}

// Добавляем номер страницы, если он больше 1 (актуально только для пагинируемых страниц)
if (
    $page > 1 &&
    ($current_page_type === "index" ||
        $current_page_type === "category" ||
        $current_page_type === "gender")
) {
    echo '<span class="breadcrumb-separator"> &gt; </span><span>Сторінка - ' .
        htmlspecialchars((string) $page) .
        "</span>";
}

echo "</div>"; // Закрытие div.breadcrumbs
echo "</section>"; // Закрытие section.page-header-block
