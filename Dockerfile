FROM php:7.3-apache-stretch

LABEL maintainer="Matthias Riegler <me@xvzf.tech>"

RUN apt-get update && apt-get install --yes libpq-dev && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install mbstring pdo pdo_pgsql \ 
    && a2enmod rewrite negotiation \
    && docker-php-ext-install opcache

COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf 

WORKDIR /srv/app
