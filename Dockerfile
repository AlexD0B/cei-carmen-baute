FROM bitnami/laravel:11
COPY . /app
RUN composer install --no-dev --optimize-autoloader
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]