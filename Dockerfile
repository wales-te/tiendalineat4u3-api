FROM dunglas/frankenphp:1.2-php8.3

WORKDIR /app

# Extensiones necesarias
RUN install-php-extensions pdo_mysql pdo_sqlite intl opcache

COPY . /app

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Caches de Laravel (si no hay .env, copiamos el de ejemplo para no fallar en build)
RUN php -r "file_exists('.env') || copy('.env.example', '.env');" && \
    php artisan key:generate --force || true && \
    php artisan config:cache || true && \
    php artisan route:cache || true && \
    php artisan view:cache || true

ENV SERVER_NAME=:8080
ENV DOCUMENT_ROOT=/app/public
EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
