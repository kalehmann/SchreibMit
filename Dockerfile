FROM php:7.4-apache

# Setze das DocumentRoot auf den public Ornder von Symfony
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Unzip installieren (wird von Compsoer benötigt)
RUN apt-get update \
    	&& apt-get upgrade -y \
    	&& apt-get install --no-install-recommends -y \
	unzip \
	&& rm -rf /var/lib/apt/lists/*

# Composer installieren
RUN \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --filename=composer --install-dir=/usr/local/bin/ \
    && php -r "unlink('composer-setup.php');"

# PHP Extensions zur Datenbankanbindung
RUN docker-php-ext-install mysqli pdo pdo_mysql