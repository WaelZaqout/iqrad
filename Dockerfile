FROM php:8.2-cli

# تثبيت المتطلبات
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# مجلد العمل
WORKDIR /app

# نسخ المشروع
COPY . .

# تثبيت حزم Laravel
RUN composer install --no-dev --optimize-autoloader

# فتح المنفذ
EXPOSE 10000

# تشغيل Laravel
CMD php -S 0.0.0.0:10000 -t public
