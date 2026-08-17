<?php

declare(strict_types=1);
// F:\laragon\www\newsewing.loc\includes\pagination.php

// Этот файл ожидает следующие переменные, которые должны быть определены перед его подключением:
// $page                  - Текущий номер страницы
// $total_pages           - Общее количество страниц
// $pagination_base_url   - Базовый URL для пагинации (например, "/category/slug/" или "/gender/slug/")

// Проверяем, есть ли вообще необходимость в пагинации (т.е. более 1 страницы)

if (!isset($page) || !isset($total_pages) || !isset($pagination_base_url) || $total_pages <= 1) {
    // В случае, если переменные не были переданы или страниц всего одна,
    // выводим ошибку в лог (для отладки), но не останавливаем работу и не отображаем пагинацию.
    error_log("Ошибка: Не все необходимые переменные переданы в pagination.php или пагинация не нужна. (\$page: " . ($page ?? 'N/A') . ", \$total_pages: " . ($total_pages ?? 'N/A') . ", \$pagination_base_url: " . ($pagination_base_url ?? 'N/A') . ")");
    return; // Просто выходим
}

echo '<div class="pagination">';

// Ссылка на предыдущую страницу
if ($page > 1) {
    echo '<a href="' . htmlspecialchars((string)$pagination_base_url) . '?page=' . ($page - 1) . '">&#9668;</a>';
}

// Отображение номеров страниц
// Логика для отображения ограниченного количества страниц (например, 5-7 ссылок вокруг текущей)
$num_links_around_current = 2; // Количество ссылок по бокам от текущей страницы (например, 2 = 5 ссылок всего)
$start_page = max(1, $page - $num_links_around_current);
$end_page = min($total_pages, $page + $num_links_around_current);

// Корректировка диапазона, если он слишком "сдвинут" к началу или концу
if ($end_page - $start_page + 1 < (2 * $num_links_around_current + 1)) {
    if ($start_page == 1) {
        $end_page = min($total_pages, $start_page + (2 * $num_links_around_current));
    } elseif ($end_page == $total_pages) {
        $start_page = max(1, $total_pages - (2 * $num_links_around_current));
    }
}

// Всегда показывать ссылку на первую страницу, если она не в текущем диапазоне
if ($start_page > 1) {
    echo '<a href="' . htmlspecialchars((string)$pagination_base_url) . '?page=1">1</a>';
    if ($start_page > 2) {
        echo '<span>...</span>'; // Многоточие, если есть пропущенные страницы между 1 и $start_page
    }
}

// Вывод ссылок в вычисленном диапазоне
for ($i = $start_page; $i <= $end_page; $i++) {
    if ($i == $page) {
        echo '<span class="current-page">' . $i . '</span>'; // Текущая страница
    } else {
        echo '<a href="' . htmlspecialchars((string)$pagination_base_url) . '?page=' . $i . '">' . $i . '</a>';
    }
}

// Всегда показывать ссылку на последнюю страницу, если она не в текущем диапазоне
if ($end_page < $total_pages) {
    if ($end_page < $total_pages - 1) {
        echo '<span>...</span>'; // Многоточие, если есть пропущенные страницы между $end_page и последней
    }
    echo '<a href="' . htmlspecialchars((string)$pagination_base_url) . '?page=' . $total_pages . '">' . $total_pages . '</a>';
}

// Ссылка на следующую страницу
if ($page < $total_pages) {
    echo '<a href="' . htmlspecialchars((string)$pagination_base_url) . '?page=' . ($page + 1) . '">&#9658;</a>';
}

echo '</div>'; // Закрытие div.pagination
