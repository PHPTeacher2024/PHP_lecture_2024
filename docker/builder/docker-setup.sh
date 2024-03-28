#!/usr/bin/env bash

set -o errexit

SCRIPT_DIR=$(dirname "$(readlink -f "$0")")
CACHE_DIR=/var/www/html

PHAN_VERSION=5.3.0

function install_with_apt() {
    apt-get -qq install -y "$@"
}

function build_php_extensions() {
   # add-apt-repository ppa:ondrej/php

    # install build deps
    install_with_apt --no-install-recommends \
        libzip-dev \
        libpng-dev \
        libicu-dev

    docker-php-ext-install "-j$(nproc)" zip
    docker-php-ext-install "-j$(nproc)" gd
    docker-php-ext-install "-j$(nproc)" intl

    ln -s /usr/local/bin/php /usr/bin/php
}

function cleanup_docker_image() {
    # See also https://docs.docker.com/develop/develop-images/dockerfile_best-practices/
    apt-get -qq clean
    truncate -s 0 /var/log/*log
}

# 1) setups node 18.x
# 2) switches npm to the custom cache path
function setup_nodejs {
    curl  -fsSL --silent --location https://deb.nodesource.com/setup_18.x | bash
    install_with_apt nodejs
    npm config set cache "$CACHE_DIR/.npm" --global
}

function install_tools() {
    install_with_apt --no-install-recommends \
        sudo \
        git
}

# Installs phan static analyzer globally
setup_phan() {
    local URL=https://github.com/phan/phan/releases/download/$PHAN_VERSION/phan.phar
    curl --silent --location "$URL" -o "/usr/bin/phan"
    chmod +x "/usr/bin/phan"
}

apt-get -qq update

build_php_extensions
setup_nodejs
setup_phan
install_tools

cleanup_docker_image

# Remove this script
rm $(readlink -f $0)

