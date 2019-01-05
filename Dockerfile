FROM wordpress:4.9.8-php7.1-apache

RUN pecl -q install xdebug-2.6.0 \
	&& docker-php-ext-enable xdebug

EXPOSE 9000
