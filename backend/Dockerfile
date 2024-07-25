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

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cria um usuário não-root (estava dando erro com usuario root)
RUN useradd -ms /bin/sh -u 1000 appuser

WORKDIR /var/www/projeto-vox/backend

# Copia os arquivos do projeto para o container
COPY . .

# Ajusta as permissões dos arquivos
RUN chown -R appuser /var/www/projeto-vox/backend

# Muda para o usuário não-root
USER appuser

# Instala as dependências do Symfony e do projeto
RUN composer install --no-scripts --no-suggest --no-interaction --no-plugins

RUN composer require symfony/form:^6.2

# Copia o arquivo de configuração customizado do Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
