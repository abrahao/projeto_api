# Dockerfile
FROM php:8.1-fpm

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    vim

# Instalar extensões do PHP
RUN docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar o diretório de trabalho
WORKDIR /var/www

# Criar um novo projeto Symfony com o nome "projeto-vox"
RUN composer create-project symfony/skeleton projeto-vox

# Definir o diretório de trabalho para o projeto Symfony
WORKDIR /var/www/projeto-vox

# Instalar dependências do Symfony
RUN composer install

# Expor a porta 9000 para o PHP-FPM
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
