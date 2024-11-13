# Usar la imagen de PHP 7.1 con Apache
FROM php:7.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip  # Importante: incluir zip aquí
    
# Habilitar módulos de Apache

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar los archivos de la aplicación
COPY . .

# Instalar dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Actualiza el sistema e instala libxml2-dev
RUN apt-get update && \
    apt-get install -y libxml2-dev && \
    rm -rf /var/lib/apt/lists/*

# Instala la extensión de SOAP
RUN docker-php-ext-install soap

RUN ln -s ../storage/app/public public/storage && \
    chown -R www-data:www-data public/storage

# Configura permisos para mPDF y el directorio de almacenamiento con rutas relativas
# chmod -R 775 /var/www/vendor/mpdf/mpdf/tmp && \
# chown -R www-data:www-data /var/www/vendor/mpdf && \
RUN chmod -R 775 /var/www/storage/app/public && \
    chown -R www-data:www-data /var/www/storage/app/public && \
    chmod 775 /var/www/public/storage

# Copiar el archivo de configuración de PHP
COPY .docker/php/php.ini /usr/local/etc/php/php.ini

    
# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache


# Exponer el puerto 9000 y ejecutar PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
