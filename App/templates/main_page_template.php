<?php
// f:\newsewing_local\app\templates\main_page_template.php
// Этот файл содержит всю HTML-разметку для главной страницы и пагинации.
// routing.php уже подключил link.php, generate_img.php и index_config.php,
// поэтому все переменные, такие как $articles, $page, $page_count, уже доступны.

// --- НАШИ ИЗМЕНЕНИЯ НАЧИНАЮТСЯ ЗДЕСЬ ---
// Теперь нам нужно убедиться, что мы правильно получаем номер страницы из URL.
// Если в .htaccess есть правило для /page/<номер>/, то оно добавляет параметр page в $_GET.
// Если URL - это корень '/', то $_GET['page'] будет пустым, и мы используем 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
require_once __DIR__ . '/../scripts/generate_img.php'; // Подключаем новый файл
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Швейних справ Майстер | Сторінка - <?= htmlspecialchars((string)$page) ?> </title>

    <?php
    $base_url_for_canonical = $base_url;

    // ОБНОВЛЕННАЯ ЛОГИКА ДЛЯ КАНОНИЧЕСКОЙ ССЫЛКИ
    $canonical_url = $base_url_for_canonical;
    if ($page > 1) {
        $canonical_url .= '/page/' . $page;
    }
    echo '<link rel="canonical" href="' . htmlspecialchars((string)$canonical_url) . '" />';
    
    // ОБНОВЛЕННАЯ ЛОГИКА ДЛЯ ПРЕДЫДУЩЕЙ СТРАНИЦЫ
    if ($page > 1) {
        $prev_page_url = $base_url_for_canonical;
        if (($page - 1) > 1) {
            $prev_page_url .= '/page/' . ($page - 1);
        }
        echo '<link rel="prev" href="' . htmlspecialchars((string)$prev_page_url) . '" />';
    }
    
    // ОБНОВЛЕННАЯ ЛОГИКА ДЛЯ СЛЕДУЮЩЕЙ СТРАНИЦЫ
    if ($page < $page_count) {
        echo '<link rel="next" href="' . htmlspecialchars((string)$base_url_for_canonical . '/page/' . ($page + 1)) . '" />';
    }
    ?>

    <style>@charset "UTF-8";.nav>ul>li>a:after,.nav>ul>li>a:before{content:'';bottom:0;height:1px;width:100%}.footer_menu>a,.pagination>a,.pagination>span{background-color:#f5f5f5;cursor:pointer;display:block}.card_img>a>picture>img,.card_title>a,.footer_menu>a,.logo>a:hover,.nav-toggle,a:hover{cursor:pointer}:root{font-family:Arial,Helvetica,"Segoe UI Emoji","Noto Color Emoji","Apple Color Emoji",sans-serif;font-size:calc(.4em + 1vw);box-sizing:border-box}*,::after,::before{box-sizing:inherit}.footer,.footer_menu>a,.pagination>a,.pagination>span{box-sizing:border-box;text-align:center}body{margin:0;padding:0;font-size:1.375rem;line-height:1.5;-webkit-animation:1s infinite bugfix}body *+*{margin-top:.5em}a:link{color:#1476b8;font-weight:700;text-decoration:none}.page-header-block .breadcrumbs a:hover,a:hover{text-decoration:underline}a:visited{color:#1430b8}.card_title>a,.footer_menu>a,.nav h2 a,.nav-toggle:after,.nav>ul>li>a,.pagination>a,.pagination>span{text-decoration:none}a:active{color:#b81414}.article_copyright h3,.center,.footer_ss,.schetchiki{text-align:center}.nav{width:100%;min-width:100%;height:100%;position:fixed;top:0;bottom:0;margin:0;right:-100%;padding:15px 20px;-webkit-transition:right .3s;-moz-transition:right .3s;transition:right .3s;background:rgba(0,0,0,.85);z-index:2000}.nav-toggle{position:absolute;right:100%;top:0;padding:.5em;background:inherit;color:#dadada;font-size:1.2em;line-height:1;z-index:2001;-webkit-transition:color .25s ease-in-out;-moz-transition:color .25s ease-in-out;transition:color .25s ease-in-out}.nav-toggle:after{content:'\2630'}.nav-toggle:hover{color:#f4f4f4}[id=nav-toggle]{position:absolute;display:none}[id=nav-toggle]:checked~.nav>.nav-toggle{left:auto;right:2px;top:0}[id=nav-toggle]:checked~.nav{right:0;box-shadow:-4px 0 20px 0 rgba(0,0,0,.5);-moz-box-shadow:-4px 0 20px 0 rgba(0,0,0,.5);-webkit-box-shadow:-4px 0 20px 0 rgba(0,0,0,.5);overflow-y:auto}[id=nav-toggle]:checked~main>article{-webkit-transform:translateX(-100%);-moz-transform:translateX(-100%);transform:translateX(-100%)}[id=nav-toggle]:checked~.nav>.nav-toggle:after{content:'\2715'}@-webkit-keyframes bugfix{to{padding:0}}@media screen and (min-width:360px){body,html{margin:0;overflow-x:hidden}}@media screen and (max-width:360px){body,html{margin:0;overflow-x:hidden}.nav{width:100%;box-shadow:none}}.article_copyright,.card,.page-header-block{box-shadow:0 0 .5em rgba(0,0,0,.1)}.nav h2{width:90%;padding:0;margin:.1em 0;text-align:center;text-shadow:rgba(255,255,255,.1) -1px -1px 1px,rgba(0,0,0,.5) 1px 1px 1px;font-size:1.2em;line-height:1.3em;opacity:0;transform:scale(.1,.1);-ms-transform:scale(.1,.1);-moz-transform:scale(.1,.1);-webkit-transform:scale(.1,.1);transform-origin:0 0;-ms-transform-origin:0 0;-moz-transform-origin:0 0;-webkit-transform-origin:0 0;transition:opacity .8s,transform .8s;-moz-transition:opacity .8s,-moz-transform .8s;-webkit-transition:opacity .8s,-webkit-transform .8s}.nav h2 a{color:#dadada;text-transform:uppercase}.nav h2 a:hover{color:#fff}[id=nav-toggle]:checked~.nav h2{opacity:1;transform:scale(1,1);-ms-transform:scale(1,1);-moz-transform:scale(1,1);-webkit-transform:scale(1,1)}.nav>ul{display:block;margin:0;padding:0;list-style:none}.nav>ul>li{line-height:2.5;opacity:0;-webkit-transform:translateX(50%);-moz-transform:translateX(50%);-ms-transform:translateX(50%);transform:translateX(50%);-webkit-transition:opacity .5s .1s,-webkit-transform .5s .1s;-moz-transition:opacity .5s .1s,-moz-transform .5s .1s;transition:opacity .5s .1s,transform .5s .1s}[id=nav-toggle]:checked~.nav>ul>li{opacity:1;-webkit-transform:translateX(0);-moz-transform:translateX(0);-ms-transform:translateX(0);transform:translateX(0)}.nav>ul>li:nth-child(2){-webkit-transition:opacity .5s .2s,-webkit-transform .5s .2s;transition:opacity .5s .2s,transform .5s .2s}.nav>ul>li:nth-child(3){-webkit-transition:opacity .5s .3s,-webkit-transform .5s .3s;transition:opacity .5s .3s,transform .5s .3s}.nav>ul>li:nth-child(4){-webkit-transition:opacity .5s .4s,-webkit-transform .5s .4s;transition:opacity .5s .4s,transform .5s .4s}.nav>ul>li:nth-child(5){-webkit-transition:opacity .5s .5s,-webkit-transform .5s .5s;transition:opacity .5s .5s,transform .5s .5s}.nav>ul>li:nth-child(6){-webkit-transition:opacity .5s .6s,-webkit-transform .5s .6s;transition:opacity .5s .6s,transform .5s .6s}.nav>ul>li:nth-child(7){-webkit-transition:opacity .5s .7s,-webkit-transform .5s .7s;transition:opacity .5s .7s,transform .5s .7s}.nav>ul>li>a{display:inline-block;position:relative;padding:0;font-family:'Open Sans',sans-serif;font-weight:300;font-size:1em;color:#cbcbcb;width:100%;-webkit-transition:color .5s,padding .5s;-moz-transition:color .5s,padding .5s;transition:color .5s,padding .5s}.nav>ul>li>a:focus,.nav>ul>li>a:hover{color:#fff;padding-left:1em}.nav>ul>li>a:before{display:block;position:absolute;right:0;-webkit-transition:width;transition:width}.nav>ul>li>a:after{display:block;position:absolute;left:0;background:#f5f5f5;-webkit-transition:width .5s;transition:width .5s}.nav>ul>li>a:hover:before{width:99%;background:#5ff5d0;-webkit-transition:width .5s;transition:width .5s}.nav>ul>li>a:hover:after{width:99%;background:0 0;-webkit-transition:width;transition:width}.logo img{margin-top:0;max-width:100%;height:auto;display:block}.page-header-block{max-width:95%;margin:1em auto;border:1px solid #f5f5f5;border-radius:.5em;display:flex;justify-content:center;align-items:center;min-height:3em}.page-header-block .breadcrumbs{font-size:.9em;color:#555;margin:0;display:flex;flex-wrap:wrap;justify-content:center;align-items:center;list-style:none;padding:0;line-height:1.4}.page-header-block .breadcrumbs a{color:#1476b8;font-weight:400;text-decoration:none;margin:0 .2em}.page-header-block .breadcrumbs span{color:#333;font-weight:700;margin:0 .2em}.footer_menu>a:hover,.pagination>.current_page,.pagination>a:hover{background-color:#1476b8;color:#f5f5f5}.breadcrumb-separator{color:#666;padding:0 .2em}.pagination{display:flex;flex-direction:row;gap:.5em;margin:1em auto;max-width:95%;flex-wrap:wrap;justify-content:center}.pagination>a,.pagination>span{margin:0;padding:0;width:auto;min-width:2em;border:1px solid #1476b8;border-radius:.3em;transition:.3s;line-height:2em;color:#1476b8}.pagination>a:hover{border-color:#1476b8}.pagination>.current_page{font-weight:700;border-color:#1476b8;cursor:default}.pagination>.disabled{background-color:#fff;color:#ccc;border-color:#ccc;cursor:not-allowed}.footer{padding:20px;border-top:1px solid #e0e0e0;width:100%;margin-top:2em}.footer_menu{display:flex;flex-direction:row;gap:.5em;flex-wrap:wrap;justify-content:center;list-style:none;padding:0;margin:0 0 15px}.footer_menu>a{margin:0;padding:.5em 1em;flex-grow:1;flex-basis:auto;max-width:450px;border:1px solid #1476b8;border-radius:.3em;transition:.3s;line-height:1.2;color:#1476b8;white-space:normal;word-wrap:break-word;overflow-wrap:break-word}.footer_menu>a:hover{border-color:#1476b8;transition:.3s}.copyright_text{font-size:.85em;color:#777;text-align:center;margin-top:15px}@media screen and (max-width:768px){.page-header-block{padding:.8em;margin:.8em auto}}@media screen and (min-width:1445px){.page-header-block{width:70%;margin:1em auto}.footer{width:70%;margin:0 auto;display:block}}.main{margin:0 auto}.card{margin-top:1em;padding:.5em;border:1px solid #f5f5f5;border-radius:.5em}.card_img{aspect-ratio:1/1;width:100%}.card_img>a>picture>img{padding:.1em;width:100%;height:auto;object-fit:cover;transition:.3s}.card_img>a>picture>img:hover{opacity:.33;transition:.3s}.card_title>a{font-size:1.6rem;display:block;border:1px solid #000;color:#000;padding:.5em;border-radius:.3em;text-align:center;overflow:hidden;text-overflow:ellipsis;transition:.3s}.card_title>a:hover{background-color:#f5f5f5;transition:.3s}.article_copyright{background:#f9f9f9;padding:.5em;border:1px solid #000;border-radius:.3em}.article_copyright a{display:block;transition:.3s}.cat_title{max-width:95%;margin:0 auto;padding:.5em;border:1px solid #f5f5f5;border-radius:.5em;font-size:1rem}
    
    /* ОБНОВЛЕННЫЕ ПРАВИЛА ДЛЯ УПРАВЛЕНИЯ РАЗМЕРАМИ СЕТКИ СТАТЕЙ */
    .articles-grid{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        grid-gap: 1em;
        max-width: 100%;
    }
    
    @media screen and (min-width: 960px){
        .card_title>a{font-size:1rem}
    }
    
    @media screen and (min-width: 1440px){
        .cat_title,main{
            width:70%;
            margin:0 auto;
        }
        .articles-grid{
            width:100%;
            max-width:none;
            box-sizing:border-box;
        }
        .card_title>a{font-size:1rem}
    }
    </style>
    <link rel="icon" href="<?= $base_url ?>/img/favicon.svg" type="image/svg+xml">
    <meta name="description"
          content="<?= htmlspecialchars("Швейних справ Майстер. Конструювання та моделювання одягу, Базові викрійки, Викрійки своїми руками, Готові викрійки, Завантажити викрійку pdf, Конструювання та моделювання одягу | Сторінка - " . $page) ?>"/>
    <meta name="author" content="Автор: Валентіна Нівіна, Ілюстрації: Олександр Нівін, Леся Нівін">
    <meta name="robots" content="index,follow">

    <!-- START ADSENSE BLOCK: DO NOT MODIFY -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1848418548858506"
            crossorigin="anonymous"></script>
    <script async src="https://fundingchoicesmessages.google.com/i/pub-1848418548858506?ers=1" nonce="OefQJ4dPGqVsqdZ3pSzQeg"></script><script nonce="OefQJ4dPGqVsqdZ3pSzQeg">(function() {function signalGooglefcPresent() {if (!window.frames['googlefcPresent']) {if (document.body) {const iframe = document.createElement('iframe'); iframe.style = 'width: 0; height: 0; border: none; z-index: -1000; left: -1000px; top: -1000px;'; iframe.name = 'googlefcPresent'; document.body.appendChild(iframe);} else {setTimeout(signalGooglefcPresent, 0);}}}signalGooglefcPresent();})();</script>
    <!-- END ADSENSE BLOCK: DO NOT MODIFY -->
</head>
<body>

<?php require_once __DIR__ . '/../includes/header.php'; ?>
<?php
$current_page_type = 'index';
$page_header_title = 'Статті';
$page_header_slug = '';

require_once __DIR__ . '/../includes/page_header_section.php';
?>
<main class="main">
    <?php
    // Вызываем новую функцию renderArticleCards из generate_img.php
    renderArticleCards($articles, $base_url);
    ?>
</main>

<div class="pagination">
    <?php
    $current_page_num = $page;
    $total_pages = $page_count;
    $range = 2;

    // ОБНОВЛЕННАЯ ЛОГИКА ДЛЯ ПРЕДЫДУЩЕЙ СТРАНИЦЫ
    if ($current_page_num > 1) {
        $prev_page_link_url = $base_url_for_canonical;
        if (($current_page_num - 1) > 1) {
            $prev_page_link_url .= '/page/' . ($current_page_num - 1);
        }
        echo '<a href="' . htmlspecialchars((string)$prev_page_link_url) . '"> &#9668; </a>';
    } else {
        echo '<span class="disabled"> &#9668; </span>';
    }

    if ($current_page_num - $range > 1) {
        echo '<a href="' . htmlspecialchars((string)$base_url_for_canonical) . '">1</a>';
        if ($current_page_num - $range > 2) {
            echo '<span>...</span>';
        }
    }

    for ($i = max(1, $current_page_num - $range); $i <= min($total_pages, $current_page_num + $range); $i++) {
        $page_link_url = $base_url_for_canonical;
        if ($i > 1) {
            $page_link_url .= '/page/' . $i;
        }

        if ($i == $current_page_num) {
            echo '<span class="current_page">' . htmlspecialchars((string)$i) . '</span>';
        } else {
            echo '<a href="' . htmlspecialchars((string)$page_link_url) . '">' . htmlspecialchars((string)$i) . '</a>';
        }
    }

    if ($current_page_num + $range < $total_pages) {
        if ($current_page_num + $range < $total_pages - 1) {
            echo '<span>...</span>';
        }
        echo '<a href="' . htmlspecialchars((string)$base_url_for_canonical . '/page/' . $total_pages) . '">' . htmlspecialchars((string)$total_pages) . '</a>';
    }

    // ОБНОВЛЕННАЯ ЛОГИКА ДЛЯ СЛЕДУЮЩЕЙ СТРАНИЦЫ
    if ($current_page_num < $total_pages) {
        echo '<a href="' . htmlspecialchars((string)$base_url_for_canonical . '/page/' . ($current_page_num + 1)) . '"> &#9658; </a>';
    } else {
        echo '<span class="disabled"> &#9658; </span>';
    }
    ?>
</div>
<?php require_once __DIR__ . '/../App/includes/footer.php'; ?>
</body>
</html>
