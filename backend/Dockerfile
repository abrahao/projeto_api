FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    zip \
    && pecl install apcu && docker-php-ext-enable apcu

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/projeto-vox/backend

# Copia os arquivos do projeto para o container
COPY . .

# Instala as dependências do Symfony e do projeto
RUN composer install --no-scripts --no-suggest --no-interaction

# Define as permissões para o diretório
RUN chown -R www-data:www-data /var/www/projeto-vox/backend

# Copia o arquivo de configuração customizado para o Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Inicia o servidor Apache
CMD ["apache2-foreground"]
