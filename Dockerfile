FROM php:8.1-fpm

# Install dependencies
RUN --mount=target=/var/lib/apt/lists,type=cache,sharing=locked \
    --mount=target=/var/cache/apt,type=cache,sharing=locked \
    rm -f /etc/apt/apt.conf.d/docker-clean \
    && echo 'Binary::apt::APT::Keep-Downloaded-Packages "true";' > /etc/apt/apt.conf.d/keep-cache \
    && apt-get update \
    && apt-get install -y --no-install-recommends git unzip libicu-dev

# Install extensions
RUN  docker-php-ext-install -j$(nproc) intl

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
