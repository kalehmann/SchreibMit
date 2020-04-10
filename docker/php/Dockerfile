FROM php:7.4-fpm

# Unzip installieren (wird von Compsoer benötigt)
RUN apt-get update \
    	&& apt-get upgrade -y \
    	&& apt-get install --no-install-recommends -y \
	unzip \
	&& rm -rf /var/lib/apt/lists/*

# Composer installieren
RUN \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --filename=composer --install-dir=/usr/local/bin/ \
    && php -r "unlink('composer-setup.php');"

# PHP Extensions zur Datenbankanbindung
RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www