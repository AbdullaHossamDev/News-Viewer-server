FROM php:7.2-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

#
# PHP Dependencies
#
# FROM composer:1.7 as vendor

# COPY database/ database/

# COPY composer.json composer.json
# COPY composer.lock composer.lock

# RUN composer install \
#     --ignore-platform-reqs \
#     --no-interaction \
#     --no-plugins \
#     --no-scripts \
#     --prefer-dist


# #
# # Frontend
# #
# FROM node:12.2.0-alpine as frontend

# RUN mkdir -p /app/public

# WORKDIR /app

# COPY package*.json webpack.mix.js /app/

# RUN npm install
# # COPY resources/ /app/resources/assets/
# # RUN npm run build

# #
# # Application
# #
# FROM php:7.2-stretch

# COPY . /var/www/html
# COPY --from=vendor /app/vendor/ /var/www/html/vendor/
# COPY --from=frontend /app/public/js/ /var/www/html/public/js/
# COPY --from=frontend /app/public/css/ /var/www/html/public/css/
# COPY --from=frontend /app/mix-manifest.json /var/www/html/mix-manifest.json