FROM php:8.1-apache  

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    zip \
    && pecl install apcu && docker-php-ext-enable apcu

# Habilita o módulo de reescrita do Apache
RUN a2enmod rewrite

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define o diretório de trabalho
WORKDIR /var/www/projeto-vox/backend

# Copia os arquivos do projeto para o container
COPY . .

# Define as permissões corretas para o diretório (estava dando erro)
RUN chown -R www-data:www-data /var/www/projeto-vox/backend

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Instala as dependências do Symfony
RUN composer install --no-scripts --no-suggest --no-interaction

EXPOSE 80

# Inicia o servidor Apache
CMD ["apache2-foreground"]
