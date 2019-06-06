#!/usr/bin/env bash
APP_ENV=${APP_ENV:-prod}

if [[ ! "dev" == "$APP_ENV" ]]; then
    composer install --no-dev
    yarn install --production
    yarn run build
else
    composer install
    yarn install
    yarn run build
    yarn run watch
fi