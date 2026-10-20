FROM php:8.3-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies, compile PHP extensions, and clean up in a single layer
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libmemcached-dev \
    zlib1g-dev \
    libssl-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Get latest Composer from the official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
# COPY . /var/www

# Expose port 9000 and start php-fpm server
# EXPOSE 9000

# Adjust permissions for Laravel storage
# RUN chown -R $user:www-data /var/www/storage /var/www/bootstrap/cache

USER $user
