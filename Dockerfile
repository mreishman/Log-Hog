FROM php:8.6.0-apache-trixie

COPY Docker/apache2/loghog.conf /etc/apache2/conf-available/loghog.conf
COPY Docker/php/loghog.ini /usr/local/etc/php/conf.d/loghog.ini
RUN a2enmod headers && a2enconf loghog

WORKDIR /var/www/html
COPY . .
RUN mkdir -p tmp/loghogBackupHistoryLogs tmp/loghogBackupArchiveLogs \
    && chown -R www-data:www-data local session tmp
