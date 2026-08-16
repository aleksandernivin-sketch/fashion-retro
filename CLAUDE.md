# fashion-retro — сайт fashion-retro.com

## Контекст
Часть монорепо ~/projects/nws/. Движок в nws-core/ (git submodule).

## Стек
PHP 8.5, FrankenPHP, PostgreSQL 18, Tailwind CSS, Alpine.js, HTMX

## Локальные порты
- :81  — FrankenPHP (веб)
- :5433 — PostgreSQL
- :8979 — CloudBeaver

## БД
- fashionretro_db (postgres, user: nivin)

## Запуск
docker compose up -d

## Структура
- nws-core/   — движок (submodule, не редактировать здесь)
- App/        — site-specific: Views, Controllers, Config
- public/     — веб-рут
- downloads/  — файлы паттернов (вне public)
- storage/    — сессии
- vendor/     — Composer
