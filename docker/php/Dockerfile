FROM php:8.3-fpm

#system dependencies and clear cache
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

#  PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user (non root) for composer and artisan commands
RUN useradd -G www-data,root -u 1000 -d /home/dev dev && \
    mkdir -p /home/dev/.composer && \
    chown -R dev:dev /home/dev
WORKDIR /var/www

# project permissions for new user
RUN chown -R dev:www-data /var/www

# switch to non-root user
USER dev
