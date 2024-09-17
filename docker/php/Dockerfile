FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install dependencies
RUN apt-get update && apt-get install -y bash git zip unzip openssl sudo

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install extensions
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install xdebug
RUN pecl install xdebug-3.3.2 \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

WORKDIR /app
COPY . .

COPY --from=composer:2.6.6 /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

RUN useradd -G www-data,root,sudo -u $uid -p $(openssl passwd -1 '123') -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user
#ADD . /var/www
#RUN chown -R www-data:www-data /var/www

EXPOSE 3000

