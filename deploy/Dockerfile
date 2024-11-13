# Build Stage
FROM php:8.3-fpm-alpine as build

# Install dependencies
RUN apk add --no-cache \
    zip \
    libzip-dev \
    freetype \
    freetype-dev \
    libjpeg \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    libpng \
    libpng-dev \
    oniguruma-dev \
    postgresql-dev \
    libxml2-dev \
    pkgconf \
    sqlite \
    sqlite-dev \
    && docker-php-ext-install pdo_sqlite

# Install PHP extensions
RUN docker-php-ext-configure zip && \
    docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    zip \
    pdo \
    pdo_mysql \
    bcmath \
    opcache \
    mbstring \
    xml \
    gd

# Install Composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Production Stage
FROM php:8.3-fpm-alpine

# Install production dependencies
RUN apk add --no-cache \
    nginx \
    zip \
    libzip-dev \
    freetype \
    freetype-dev \
    libjpeg \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    libpng \
    libpng-dev \
    postgresql-dev \
    libxml2-dev \
    oniguruma-dev \
    pkgconf

# Install PHP extensions
RUN docker-php-ext-configure zip && \
    docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    zip \
    pdo \
    pdo_mysql \
    bcmath \
    opcache \
    mbstring \
    xml \
    gd

# Copy nginx configuration
COPY ./deploy/nginx.conf /etc/nginx/http.d/default.conf

# Copy PHP configuration
COPY ./deploy/php.ini /usr/local/etc/php/conf.d/app.ini

# Install Composer in production stage too
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

# Copy application from build stage
COPY --from=build /var/www/html /var/www/html

WORKDIR /var/www/html

EXPOSE 80

CMD ["sh", "-c", "nginx && php-fpm"]