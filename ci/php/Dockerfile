FROM cirdan/sae2022-php:latest

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
RUN composer install --no-dev  --no-progress --no-interaction --optimize-autoloader
RUN php bin/console assets:install
RUN php bin/console cache:clear
