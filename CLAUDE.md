# fashion-retro — сайт fashion-retro.com

## Контекст
Часть монорепо ~/projects/nws/. Движок в nws-core/ (git submodule).
Сайт про ретро моду — выкройки в винтажном стиле.

## Стек
PHP 8.5, FrankenPHP, PostgreSQL 18, Tailwind CSS, Alpine.js, HTMX

## Локальные порты
- :81   — FrankenPHP (веб)
- :5433 — PostgreSQL
- :8979 — CloudBeaver

## БД
- fashionretro_db (postgres, user: nivin)
- Схема: scheme.sql (совместима с newsewing)

## Запуск
```bash
cd ~/projects/nws && make up-fr
# или
cd ~/projects/nws/fashion-retro && docker compose up -d
```

## Структура
- nws-core/        — движок (submodule, не редактировать здесь!)
- App/includes/    — хедер, футер, пагинация (site-specific)
- App/templates/   — шаблоны страниц
- App/Views/       — вьюхи (admin, shop)
- public/          — веб-рут (index.php, css, js, images)
- downloads/       — файлы паттернов (вне public)
- storage/         — сессии
- vendor/          — Composer (autoload: App\→nws-core/App/, Adm\→nws-core/Adm/)

## Конфигурация
- site.config.php  — настройки сайта (бренд, языки, роуты)
- .env             — DB credentials (не коммитится)
- composer.json    — PSR-4 маппинг на nws-core

## После клонирования
```bash
git submodule update --init --recursive
composer install
cp .env.example .env  # заполнить DB credentials
docker compose up -d
```

## Миграция данных
Старые данные в MySQL дампе: _legacy/newsewin_fr.sql
Структура старая (mfr_* таблицы) — требует конвертации в новую схему.
