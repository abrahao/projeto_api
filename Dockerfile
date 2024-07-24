FROM php:8.1-fpm

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    vim \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões do PHP
RUN docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Configurar o diretório de trabalho
WORKDIR /var/www/projeto-vox/backend

# Adicionar dependências adicionais ao Composer
RUN composer require \
    symfony/orm-pack \
    symfony/maker-bundle \
    doctrine/doctrine-migrations-bundle \
    symfony/security-bundle \
    symfony/form \
    symfony/validator \
    twig/twig \
    nelmio/api-doc-bundle

# Limpar o cache do Composer
RUN composer clear-cache

# Verificar se os pacotes foram instalados corretamente
RUN composer show twig/twig

# Instalar Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Instalar o Angular CLI
RUN npm install -g @angular/cli@latest

# Expor a porta 9000 para o PHP-FPM
EXPOSE 9000

# Iniciar o PHP-FPM
CMD ["php-fpm"]
