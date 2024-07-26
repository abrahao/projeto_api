# Use uma imagem base com PHP e Apache
FROM php:8.1-apache

# Instale as dependências do sistema
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
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilite o módulo rewrite do Apache
RUN a2enmod rewrite

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Crie um usuário não-root
RUN useradd -ms /bin/sh -u 1000 appuser

# Defina o diretório de trabalho
WORKDIR /var/www/projeto-vox/backend

# Copie os arquivos do projeto para o container
COPY --chown=appuser:appuser . .

# Mude para o usuário não-root
USER appuser

# Instale as dependências do Composer
RUN composer install --no-scripts --no-suggest --no-interaction --no-plugins

# Instale pacotes adicionais necessários para Symfony
RUN composer require symfony/form:^6.2
RUN composer require symfony/serializer
RUN composer require lexik/jwt-authentication-bundle

# Copie o arquivo de configuração customizado do Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Exponha a porta 80
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
