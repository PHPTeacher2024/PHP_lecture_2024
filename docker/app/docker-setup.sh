#!/usr/bin/env bash

# exit on any error
set -e

# Configuration values
APT_DISTRO_NAME=buster
OPENRESTY_VERSION=1.21.4.1

# avoid interactive questions when installing packages
export DEBIAN_FRONTEND=noninteractive

build_php_extensions_builder() {
    # install build deps
    apt-get -qq install --yes --no-install-recommends \
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

# Installs gnupg to add more APT repositories
setup_gnupg() {
    apt-get -qq install -y gnupg
}

add_apt_repository() {
    local FILENAME=/etc/apt/sources.list.d/$1.list
    local URL=$2
    local SECTION=$3
    echo "deb $URL $APT_DISTRO_NAME $SECTION" >"$FILENAME"
}

install_openresty() {
    curl --silent --location https://openresty.org/package/pubkey.gpg | apt-key add -
    add_apt_repository "openresty" "http://openresty.org/package/debian" "openresty"
    apt-get -qq update
    apt-get -qq install -y --no-install-recommends "openresty=${OPENRESTY_VERSION}-*"

    ln -s /usr/local/openresty/nginx/conf /etc/nginx

    mkdir -p /var/log/nginx/
    chown www-data:www-data /var/log/nginx/
}

install_tools() {
    apt-get -qq update
    apt-get -qq install -y --no-install-recommends \
        supervisor \
        sudo \
        jq
}

install_runtime_deps() {
    # Install runtime dependencies of PHP extensions
    apt-get -qq install --yes --no-install-recommends \
        libzip4 \
        libpng16-16
}

build_php_extensions() {
    # install build deps
    apt-get -qq install --yes --no-install-recommends \
        zlib1g-dev \
        libzip-dev \
        libpng-dev \
        libicu-dev

    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

    docker-php-ext-install "-j$(nproc)" gd
    docker-php-ext-install "-j$(nproc)" zip
    docker-php-ext-install "-j$(nproc)" mysqli
    docker-php-ext-install "-j$(nproc)" pdo_mysql
    docker-php-ext-install "-j$(nproc)" intl

    # remove build dependencies
    apt-get purge --auto-remove --yes \
      zlib1g-dev \
      libzip-dev \
      libpng-dev

    ln -s /usr/local/bin/php /usr/bin/php
}

# Installs tools useful during bash session in container
install_debugging_tools() {
    apt-get -qq install --yes --no-install-recommends \
        mc \
        nano \
        less
}

# Install xdebug
install_xdebug() {
    pecl install xdebug-3.1.5
    docker-php-ext-enable xdebug
}

cleanup() {
    # See also https://docs.docker.com/develop/develop-images/dockerfile_best-practices/
    apt-get -qq clean
    rm -rf /usr/src/
    truncate -s 0 /var/log/*log
}

apt-get -qq update

#build_php_extensions

cleanup_docker_image

setup_gnupg

install_tools
build_php_extensions
install_runtime_deps
install_debugging_tools
install_openresty
install_xdebug

cleanup

# Remove this script
rm "$(readlink -f "$0")"
