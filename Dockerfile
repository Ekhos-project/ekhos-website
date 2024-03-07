FROM php:8.3-fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

COPY wp-install.sh /usr/local/bin/wp-install.sh

RUN chmod +x /usr/local/bin/wp-install.sh

ENTRYPOINT ["wp-install.sh"]
CMD ["php-fpm"]
