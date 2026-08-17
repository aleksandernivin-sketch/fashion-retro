<?php

declare(strict_types=1); ?>
<footer class="main-footer" style="margin-top: 50px; padding: 30px 0; border-top: 1px solid var(--border); background: var(--sub-menu-bg);">
    <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div class="footer-copy">
            &copy; <?= "2009-" . date('Y'); ?> <strong>Швейних справ Майстер</strong>. Всі права захищені.
        </div>
        <div class="footer-links">
            <a href="/contacts" style="color: var(--text); text-decoration: none; margin-left: 20px;">Контакти</a>
            <a href="/privacy" style="color: var(--text); text-decoration: none; margin-left: 20px;">Політика конфіденційності</a>
        </div>
    </div>
</footer>

<script src="/js/app.js"></script>
<!-- HTMX + Alpine.js -->
<script src="https://unpkg.com/htmx.org@2.0.8"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>