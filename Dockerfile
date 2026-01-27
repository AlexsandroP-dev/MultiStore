FROM php:8.2-fpm

#RUN sed -i 's|http://deb.debian.org|https://deb.debian.org|g; s|http://security.debian.org|https://security.debian.org|g' /etc/apt/sources.list

WORKDIR /var/www/

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    cron \
    curl

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# RUN docker-php-ext-install pgsql pdo pdo_pgsql pdo_mysql

# Instalar extensões PHP necessárias para Laravel e Postgres
RUN docker-php-ext-install pdo_pgsql pgsql zip gd bcmath intl

ADD . /var/www
RUN chown -R www-data:www-data /var/www


# RUN apt-get update && \
#     apt-get install -y \
#     libzip-dev \
#     && docker-php-ext-install zip

# RUN docker-php-ext-install gd

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions