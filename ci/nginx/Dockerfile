FROM cirdan/sae2022-php:latest as php

ENV APP_ENV=prod

WORKDIR /var/www/html

ADD public public/
ADD src src/
ADD composer.json composer.lock ./
ADD config config/
ADD bin bin/
ADD migrations migrations/
ADD .env ./
RUN mkdir var
RUN chmod 777 -R var
RUN echo "APP_ENV=prod" > .env.local
RUN composer install --no-dev --no-progress --no-interaction --no-scripts --optimize-autoloader
RUN php bin/console assets:install



FROM cirdan/sae2022-nginx:latest

ENV APP_ENV=prod

RUN mkdir -p /var/www/html

COPY --from=php /var/www/html/public /var/www/html/
ADD ci/nginx/nginx.default.conf /etc/nginx/conf.d/default.conf
