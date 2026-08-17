<!DOCTYPE html>
<html lang="uk" class="h-full bg-gray-50 dark:bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel | NewSewing' ?></title>

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-primary: var(--color-blue-600);
            --color-secondary: var(--color-slate-800);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-900 dark:text-slate-200">

    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-slate-900 dark:border-slate-800" aria-label="Sidebar">
       <div class="h-full px-3 py-4 overflow-y-auto">
          <a href="/admin" class="flex items-center ps-2.5 mb-10">
             <span class="self-center text-xl font-bold whitespace-nowrap dark:text-white">NS <span class="text-blue-600">v85</span> Evolution</span>
          </a>
          <ul class="space-y-2 font-medium">
             <li>
                <a href="/admin/articles" hx-get="/admin/articles" hx-target="#main-content" hx-push-url="true" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-800 group">
                   <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M17 4H3a1 1 0 00-1 1v14a1 1 0 001 1h14a1 1 0 001-1V5a1 1 0 00-1-1zm-1 14H4V6h12v12zM6 8h8v2H6V8zm0 4h5v2H6v-2z"/></svg>
                   <span class="ms-3">Статті (Матриця)</span>
                </a>
             </li>
             <li>
                <a href="/admin/stats" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-800 group">
                   <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                   <span class="ms-3">Статистика</span>
                </a>
             </li>
             <li class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-800">
                <span class="px-2 text-xs font-semibold text-gray-500 uppercase">Налаштування</span>
             </li>
             <li>
                <a href="/admin/settings" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-800 group">
                   <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                   <span class="ms-3">Конфігурація</span>
                </a>
             </li>
          </ul>
       </div>
    </aside>

    <div class="sm:ml-64 bg-gray-50 dark:bg-slate-950 min-h-screen">
       <header class="sticky top-0 z-30 flex items-center justify-between px-4 py-2 bg-white border-b border-gray-200 dark:bg-slate-900 dark:border-slate-800">
          <div class="flex items-center">
             <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-slate-800">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path></svg>
             </button>
             <h1 class="ml-2 text-lg font-semibold dark:text-white" id="page-title">Панель керування</h1>
          </div>
          <div class="flex items-center gap-4">
             <div id="loading" class="htmx-indicator animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
             <div class="text-sm text-gray-500 dark:text-slate-400">Привіт, Олександр</div>
          </div>
       </header>

       <main id="main-content" class="p-4 md:p-6">
          <?= $content ?>
       </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
