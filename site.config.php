<?php

declare(strict_types=1);

return [
    'site' => [
        'name' => [
            'uk' => 'Мода Ретро',
            'en' => 'Fashion Retro',
            'de' => 'Mode Retro',
            'fr' => 'Mode Rétro',
            'es' => 'Moda Retro',
            'pt' => 'Moda Retro',
            'pl' => 'Moda Retro',
        ],
        'footer_brand'    => 'FashionRetro',
        'authors'         => 'Валентина та Олександр Нівіни',
        'copyright_start' => 2024,
        'logo'            => '/images/logo.svg',
        'default_lang'    => 'uk',
        'langs'           => ['uk', 'en', 'de', 'fr', 'es', 'pt', 'pl'],
        'base_url'        => '',
    ],

    'ui' => [
        'menu_labels' => [
            'uk' => ['open' => 'МЕНЮ', 'close' => 'ЗАКРИТИ'],
            'en' => ['open' => 'MENU', 'close' => 'CLOSE'],
            'de' => ['open' => 'MENU', 'close' => 'SCHLIESSEN'],
            'fr' => ['open' => 'MENU', 'close' => 'FERMER'],
            'es' => ['open' => 'МЕНÚ', 'close' => 'CERRAR'],
            'pt' => ['open' => 'MENU', 'close' => 'FECHAR'],
            'pl' => ['open' => 'MENU', 'close' => 'ZAMKNIJ'],
        ],
        'nav' => ['about', 'contacts', 'privacy'],
    ],

    'admin' => [
        'prefix' => '/werfnbr-fr',
        'langs'  => ['uk', 'en', 'de', 'fr', 'es', 'pt', 'pl'],
    ],

    'storage' => [
        'public_prefix' => 'public/patterns-',
        'secure_prefix' => 'downloads/patterns-',
        'year_split'    => true,
    ],

    'download' => [
        'wait_seconds' => 120,
        'pillar_ids'   => [],
        'help_slug'    => '',
    ],

    'seo' => [
        'legacy_hub_map' => [],
    ],

    'hubs' => [
        'icon_map' => [],
    ],

    'core' => [
        'controller_namespace' => 'App\\Controllers\\',
        'per_page'             => 12,
    ],
];
