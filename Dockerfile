FROM php:fpm-alpine

RUN apk update && apk add build-base

RUN docker-php-ext-install mysqli pdo pdo_mysql \
  && docker-php-ext-install bcmath


RUN apk add zlib-dev git zip

WORKDIR /app

#  ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"
