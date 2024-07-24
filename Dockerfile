FROM php:8.1-fpm

# Instalar as ependências necessárias
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    vim \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Extensões do PHP
RUN docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Diretório de trabalho
WORKDIR /var/www/projeto-vox

# Diretório de trabalho para o projeto Symfony
WORKDIR /var/www/projeto-vox/backend

# Adiciona dependências adicionais ao Composer
RUN composer require \
    symfony/orm-pack \
    symfony/maker-bundle \
    doctrine/doctrine-migrations-bundle \
    symfony/security-bundle \
    symfony/form \
    symfony/validator \
    twig/twig \
    nelmio/api-doc-bundle

# Limpa o cache do Composer
RUN composer clear-cache

# Verifica se os pacotes foram instalados corretamente
RUN composer show twig/twig

# Instalar Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Instalar o Angular CLI
RUN npm install -g @angular/cli@latest

# Porta 9000 para o PHP-FPM
EXPOSE 9000

# Inicia o PHP-FPM
CMD ["php-fpm"]
