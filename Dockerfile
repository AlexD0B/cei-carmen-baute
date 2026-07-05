# Usamos la imagen oficial y limpia de PHP 8.2
FROM php:8.2-cli

# Instalar dependencias requeridas del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar las extensiones de PHP necesarias para que Laravel y MySQL hablen sin problemas
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copiamos Composer directamente desde su imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo dentro del servidor
WORKDIR /app
COPY . /app

# Instalar dependencias de Laravel optimizadas para internet
RUN composer install --no-dev --optimize-autoloader

# Arrancar el servidor en el puerto 10000 que maneja Render de forma nativa
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]