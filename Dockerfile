FROM dunglas/frankenphp:builder-php8.3.21

# HTTPS terminates at Cloudflare.
# Internal traffic uses HTTP port 80.
ENV SERVER_NAME=:80

# FrankenPHP is behind Dokploy/Traefik.
ENV CADDY_GLOBAL_OPTIONS="servers { trusted_proxies static private_ranges trusted_proxies_strict }"

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    git \
    unzip \
    librabbitmq-dev \
    libpq-dev \
    nano

RUN install-php-extensions \
    gd \
    pcntl \
    opcache \
    pdo \
    pdo_mysql \
    zip \
    redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=oven/bun:latest /usr/local/bin/bun /usr/local/bin/bun

WORKDIR /var/www/html

COPY . .

COPY ./deploy/php.ini /usr/local/etc/php/

RUN composer install \
    --optimize-autoloader \
    --no-dev \
    --no-interaction

COPY package.json ./
COPY bun.lock ./

RUN bun install
RUN bun run build

RUN php artisan storage:link

RUN chown -R www-data:www-data storage bootstrap/cache

ENV FRANKENPHP_THREADS=8
ENV OP_CACHE_ENABLE=1

EXPOSE 8000

CMD ["sh", "-c", "rm -f bootstrap/cache/*.php && php artisan config:clear && php artisan route:clear && (php artisan storage:link || true) && OCTANE_SERVER=frankenphp php artisan optimize && php artisan octane:start --workers=8 --task-workers=4 --server=frankenphp --host=0.0.0.0 --port=8000"]