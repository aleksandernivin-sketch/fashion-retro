<?php

/**
 * app\includes\header.php
 * Старая шапка
 */

declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="<?= $lang ?? 'uk'; ?>" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_header_title ?? 'Швейних справ Майстер'; ?></title>
    <link rel="stylesheet" href="/css/style.css">

</head>

<body>

    <header class="main-header">
        <div class="header-container">
            <a href="/" class="header__logo">
                <img src="/images/logo.svg" alt="Швейних справ Майстер" class="logo-image">
                <span class="site-title">Швейних справ Майстер</span>
            </a>

            <div class="header__tools">
                <button class="theme-toggle" id="themeBtn">
                    <svg class="sun-icon" width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 7a5 5 0 100 10 5 5 0 000-10zM2 13h2a1 1 0 100-2H2a1 1 0 100 2zm18 0h2a1 1 0 100-2h-2a1 1 0 100 2zM11 2v2a1 1 0 100 2V2a1 1 0 100-2zm0 18v2a1 1 0 100 2v-2a1 1 0 100-2z"></path>
                    </svg>
                </button>
                <button class="burger-menu" id="burgerBtn"><span></span></button>
            </div>

            <nav class="header__nav" id="mobileNav">
                <ul class="menu-root">
                    <li class="menu-unit"><a href="/">ГОЛОВНА</a></li>

                    <?php if (!empty($pillars)): ?>
                        <?php foreach ($pillars as $pillar): ?>
                            <li class="menu-hub">
                                <div class="menu-hub-title">
                                    <?php
                                    $langPrefix = ($lang === 'uk') ? '' : '/' .  ;
                                    $hubUrl = $langPrefix . '/' . htmlspecialchars($pillar['slug']);
                                    ?>
                                    <a href="<?= $hubUrl ?>" style="text-decoration: none; color: inherit; display: block;">
                                        <?= htmlspecialchars($pillar['title']) ?>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>