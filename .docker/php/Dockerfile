FROM php:7.3-apache
ENV APACHE_DOCUMENT_ROOT /var/www

RUN apt-get update \
    && pecl install xdebug \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget nodejs libzip-dev libzip4 zip unzip\
    gnupg gnupg1 gnupg2 \
    libpq-dev zlib1g-dev \
    sudo

RUN docker-php-ext-install pdo pdo_mysql zip

RUN rm -rf /etc/apache2/sites-available/*.conf
RUN sed -i '/Global configuration/a \
ServerName localhost \
' /etc/apache2/apache2.conf
ADD .docker/config/vhosts /etc/apache2/sites-enabled/

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
	mv composer.phar /usr/local/bin/composer

RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m
RUN passwd -d dev

RUN rm -rf /var/lib/apt/lists/*
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen

RUN echo "dev ALL=(ALL) ALL" > /etc/sudoers
RUN echo "root ALL=(ALL) ALL" > /etc/sudoers

RUN a2enmod rewrite

ADD . /var/www
WORKDIR /var/www

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get update && apt-get install -y --no-install-recommends --no-install-suggests nodejs yarn

RUN rm -rf var/cache/*
RUN composer install --no-dev
RUN yarn install
RUN yarn run build
RUN yarn install --production

EXPOSE 80
