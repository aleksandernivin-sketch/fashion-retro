<?php
declare(strict_types=1);

/**
 * Универсальный компонент пагинации (v2.0)
 * Использует $base_pagination_url для гибкости
 */

// Определяем базовый путь: приоритет у специально переданной переменной
$pag_path = $base_pagination_url ?? $base_url ?? '';
$range = 2;
$page = (int)($page ?? 1);
$total_pages = (int)($total_pages ?? 1);
?>

<div class="pagination">
    <?php
    // --- Кнопка НАЗАД ---
    if ($page > 1) {
        $prev_url = ($page - 1 > 1) ? $pag_path . "?page=" . ($page - 1) : $pag_path;
        echo '<a href="' . htmlspecialchars((string)$prev_url) . '" aria-label="Попередня"> &#9668; </a>';
    } else {
        echo '<span class="disabled"> &#9668; </span>';
    }

    // --- Первая страница и многоточие ---
    if ($page - $range > 1) {
        echo '<a href="' . htmlspecialchars((string)$pag_path) . '">1</a>';
        if ($page - $range > 2) echo "<span>...</span>";
    }

    // --- Цифровые ссылки (Центр) ---
    for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) {
        $url = ($i > 1) ? $pag_path . "?page=" . $i : $pag_path;
        if ($i === $page) {
            echo '<span class="current_page">' . $i . '</span>';
        } else {
            echo '<a href="' . htmlspecialchars((string)$url) . '">' . $i . '</a>';
        }
    }

    // --- Последняя страница и многоточие ---
    if ($page + $range < $total_pages) {
        if ($page + $range < $total_pages - 1) echo "<span>...</span>";
        echo '<a href="' . htmlspecialchars($pag_path . "?page=" . $total_pages) . '">' . $total_pages . '</a>';
    }

    // --- Кнопка ВПЕРЕД ---
    if ($page < $total_pages) {
        echo '<a href="' . htmlspecialchars($pag_path . "?page=" . ($page + 1)) . '" aria-label="Наступна"> &#9658; </a>';
    } else {
        echo '<span class="disabled"> &#9658; </span>';
    }
    ?>
</div>