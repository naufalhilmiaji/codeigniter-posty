FROM php:fpm-alpine3.16

RUN sed -i 's/9000/9009/' /usr/local/etc/php-fpm.d/zz-docker.conf
RUN set -ex \
  && apk --no-cache add \
    postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql pgsql intl
