FROM php:7.1-apache

ENV DEBIAN_FRONTEND noninteractive
ENV PHP_UPLOAD_MAX_FILESIZE 10M
ENV PHP_POST_MAX_SIZE 10M

# Apache extensions
RUN apt-get update && \
    apt-get -y install \
    apache2-utils pwgen vim wget

RUN apt-get install -y apt-transport-https lsb-release ca-certificates
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ jessie main" > /etc/apt/sources.list.d/php.list
RUN apt-get update && apt-get install -y php7.1-cli php7.1-curl php7.1-intl php7.1-json php7.1-mbstring php7.1-mcrypt php7.1-pdo-mysql mysql-server

# Configure extensions
RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite

COPY ./src/apache2/*.template /etc/apache2/sites-available/

RUN useradd -ms /bin/bash mark && usermod -a -G www-data mark

ADD ./src/init.sh /usr/local/bin/init.sh
ADD ./src/run.sh /usr/local/bin/run.sh
RUN chmod 755 /usr/local/bin/*.sh

RUN chown www-data:www-data -R /var/www/html

CMD ["/usr/local/bin/run.sh"]



