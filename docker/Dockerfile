FROM alpine:3.5

RUN apk update && \
  apk add --no-cache \
  apache2 \
  apache2-ssl \
  php5 \
  php5-dev \
  php5-apache2 \
  php5-cli \
  php5-phar \
  php5-zlib \
  php5-zip \
  php5-bz2 \
  php5-ctype \
  php5-mysqli \
  php5-mysql \
  php5-pdo_mysql \
  php5-pdo \
  php5-json \
  php5-curl \
  php5-gd \
  php5-mcrypt \
  php5-openssl \
  php5-dom \
  php5-xml \
  php5-iconv \
  curl \
  wget \
  make \
  autoconf \
  gcc \
  g++ \
  supervisor && \
  mkdir -p /run/apache2 && \
  chown -R apache:apache /run/apache2 && \
  mkdir -p /var/www && \
  chown -R apache:apache /var/www

# https://hub.docker.com/r/janes/alpine-lamp/~/dockerfile/
COPY ./docker/config/httpd.conf /etc/apache2/httpd.conf
COPY ./docker/config/vhost.conf /etc/apache2/vhost.conf
COPY ./docker/config/php.ini /etc/php5/php.ini
# Supervisor configuration
COPY ./docker/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
