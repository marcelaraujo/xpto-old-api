# PHPUnit Docker Container.
FROM php:5.6-cli
MAINTAINER Marcel Araujo <ceceldada@gmail.com>

# Configure deps
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    g++ \
    git \
    zip \
    unzip \
    locales \
    zlib1g-dev \
    libssl-dev \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    libmcrypt-dev \
    libbz2-dev \
    libxml2-dev \
    libxslt-dev \
    libpq-dev \
    libsqlite3-dev \
    libcurl4-openssl-dev \
    libfreetype6 \
    libicu-dev \
    libgmp-dev \
    libldb-dev \
    libldap2-dev \
    libpspell-dev \
    librecode-dev \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Configure PHP
RUN pecl channel-update pecl.php.net \
 && pecl install xdebug-2.5.5 \
 && pecl clear-cache \
 && docker-php-ext-configure intl \
 && docker-php-ext-enable opcache \
 && docker-php-ext-install -j$(nproc) bcmath bz2 calendar mbstring exif gettext intl pdo_mysql pdo_pgsql pspell shmop soap sockets xmlrpc xsl zip \
 && docker-php-source delete \
 && printf '[PHP]\ndate.timezone = "Europe/Lisbon"\n' > /usr/local/etc/php/conf.d/common.ini

# Configure Timezone
RUN ln -snf /usr/share/zoneinfo/Europe/Lisbon /etc/localtime \
 && echo "Europe/Lisbon" > /etc/timezone

# Goto temporary directory.
WORKDIR /tmp

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

# Run composer and phpunit installation.
RUN composer require "phpunit/phpunit:~5.7.26" --prefer-source --no-interaction \
 && ln -s /tmp/vendor/bin/phpunit /usr/local/bin/phpunit

# Set up the application directory.
VOLUME ["/app"]
WORKDIR /app

# Set up the command arguments.
ENTRYPOINT ["/usr/local/bin/phpunit"]
CMD ["--help"]