FROM ubuntu:xenial

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y git wget curl build-essential vim htop \
&& apt-get update && apt-get install -y php

RUN apt-get install -y apache2 \
&& apt-get update \
&& apt-get install -y libapache2-mod-php7.0

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR

COPY Docker/apache2/sites/* /etc/apache2/sites-available/
COPY Docker/apache2/conf-available/* /etc/apache2/conf-available/
COPY Docker/apache2/conf/* /etc/apache2/conf/
COPY Docker/apache2/apache2.conf /etc/apache2/apache2.conf

RUN apt-get update && a2enconf htaccess.conf git.conf security.conf \
&& a2enmod headers rewrite ssl proxy proxy_fcgi php7.0 \
&& a2ensite loghog.conf\
&& apt-get install -y supervisor

RUN apt-get install -y php7.0-mbstring php7.0-xml php7.0-mysql php7.0-curl php7.0-gd php7.0-mcrypt php7.0-soap php-xdebug php7.0-zip

COPY Docker/php/php.ini /etc/php/7.0/apache2

COPY Docker/apache2/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY Docker/logrotate.conf /etc/logrotate.conf

RUN apt-get install -y sysstat

COPY . /srv/app

RUN chown -R www-data:www-data /srv/app \
    && a2enmod rewrite \
    && rm -rf /srv/app/Docker/ \
    && chown -R www-data:www-data /var/log/apache2

CMD ["/usr/bin/supervisord"]