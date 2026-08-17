<?php
/**
 * app/includes/head_meta.php
 * Поддержка PHP 8.5.1 | Универсальный SEO-блок
 */
declare(strict_types=1);

// 1. Определяем базовый URL для пагинации и каноникала
// Приоритет: ЧПУ раздела -> Каноникал из конфига -> Базовый URL сайта
$seo_base_url = $full_correct_chpu_gender_url ?? $current_page_canonical_url ?? $base_url;

// 2. Формируем Title
if (isset($article_data)) {
    $title_tag = ($article_data['title'] ?? 'Назва відсутня') . ' - Швейних справ Майстер';
} elseif (isset($gender_data)) {
    $title_tag = "Викрійки для " . ($gender_data['gender_type'] ?? 'разділу') . " | Сторінка - " . (int)($page ?? 1);
} else {
    $title_tag = "Швейних справ Майстер | Сторінка - " . (int)($page ?? 1);
}

// 3. Формируем Description
$desc_tag = $article_data['desk'] ?? ("Викрійки для " . ($gender_data['gender_type'] ?? 'всієї родини') . ". Сторінка - " . (int)($page ?? 1));
?>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-RL7TR0M82S"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date()); gtag('config', 'G-RL7TR0M82S');
</script>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title><?= htmlspecialchars($title_tag) ?></title>

<link rel="canonical" href="<?= htmlspecialchars((string)($current_page_canonical_url ?? $seo_base_url)) ?>" />

<?php if (isset($page) && $page > 1): ?>
    <?php $prev_val = (int)$page - 1; ?>
    <link rel="prev" href="<?= htmlspecialchars($seo_base_url . ($prev_val > 1 ? "?page=$prev_val" : "")) ?>" />
<?php endif; ?>

<?php if (isset($page, $total_pages) && $page < $total_pages): ?>
    <link rel="next" href="<?= htmlspecialchars($seo_base_url . "?page=" . ($page + 1)) ?>" />
<?php endif; ?>

<meta name="description" content="<?= htmlspecialchars($desc_tag) ?>">
<meta name="author" content="Валентіна Нівіна, Олександр Нівін, Леся Нівін">
<meta name="robots" content="index,follow">
<link rel="icon" href="<?= htmlspecialchars($base_url) ?>/img/favicon.svg" type="image/svg+xml">

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1848418548858506" crossorigin="anonymous"></script>
<script async src="https://fundingchoicesmessages.google.com/i/pub-1848418548858506?ers=1" nonce="OefQJ4dPGqVsqdZ3pSzQeg"></script>
<script nonce="OefQJ4dPGqVsqdZ3pSzQeg">
    (function(){function signalGooglefcPresent(){if(!window.frames['googlefcPresent']){if(document.body){const iframe=document.createElement('iframe');iframe.style='width:0;height:0;border:none;z-index:-1000;left:-1000px;top:-1000px;display:none;';iframe.name='googlefcPresent';document.body.appendChild(iframe);}else{setTimeout(signalGooglefcPresent,0);}}}signalGooglefcPresent();})();
</script>