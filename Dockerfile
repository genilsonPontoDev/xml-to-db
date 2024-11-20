# Usar a imagem oficial do PHP 8.2 com Apache
FROM php:8.2-apache

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instalar o Composer diretamente no container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho como /var/www/html
WORKDIR /var/www/html

# Copiar o conteúdo do projeto para o container
COPY ./src/ /var/www/html/

# Desativar exibição de erros e ajustar o error_reporting
RUN echo "display_errors = Off" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "error_reporting = E_ALL & ~E_NOTICE & ~E_WARNING" >> /usr/local/etc/php/conf.d/custom.ini

# Habilitar o módulo de reescrita do Apache (necessário para .htaccess)
RUN a2enmod rewrite

# Expor a porta 80 para acessar o serviço HTTP
EXPOSE 80

# Configurar permissões (garantir que o Apache possa acessar os arquivos corretamente)
RUN chown -R www-data:www-data /var/www/html

# Reiniciar o Apache para garantir que todas as configurações sejam aplicadas
CMD ["apache2-foreground"]
