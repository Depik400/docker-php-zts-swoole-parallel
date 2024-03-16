FROM php:zts

RUN apt-get update && apt-get install -y postgresql \
                                        libpq-dev \
                                        libzip-dev \
                                        libonig-dev \
                                        libpng-dev \
                                        libc-client-dev libkrb5-dev \
                                        libcurl4-openssl-dev \
                                        libxml2-dev

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl

RUN docker-php-ext-install  xml pgsql zip mbstring gd imap iconv ctype curl pdo

RUN pecl install redis && pecl install parallel && docker-php-ext-enable redis parallel

RUN printf "\n\n\n\n\n\nyes\n\n\n\n" | pecl install swoole && docker-php-ext-enable swoole

