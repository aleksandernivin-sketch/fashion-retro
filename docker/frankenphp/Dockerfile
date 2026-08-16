FROM dunglas/frankenphp:php8.5

# Установка системных зависимостей и PHP расширений
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    && install-php-extensions \
    pdo_pgsql \
    pgsql \
    gd \
    intl \
    zip \
    opcache

# Копируем наш Caddyfile внутрь, если он понадобится для кастомных роутов
# COPY Caddyfile /etc/caddy/Caddyfile

# Создаем папку public как ссылку на www. 
# Флаги -fn перезаписывают линк при пересборках без ошибок 'File exists'
RUN ln -sfn /var/www/html/www /var/www/html/public

WORKDIR /var/www/html