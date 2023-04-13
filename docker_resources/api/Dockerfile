# Largely inspired from  https://github.com/t3kit/ubuntu18.04-php7.2-apache/blob/master/Dockerfile

FROM ubuntu:18.04

ENV DEBIAN_FRONTEND=noninteractive
ENV LC_ALL=C.UTF-8

RUN apt-get update && apt-get install -yq software-properties-common

RUN add-apt-repository ppa:ondrej/php \
    && apt-get update

RUN apt-get install -yq --no-install-recommends \
    apt-utils \
    curl \
    vim \
    # avoids a composer update
    unzip \
    # ffmpeg for file manipulation (some commands)
    ffmpeg \
    # Install git
    git \
    # Install apache
    apache2 \
    # Install php 8.2
    libapache2-mod-php8.2 \
    php8.2-cli \
    php8.2-curl \
    php8.2-fpm \
    php8.2-gd \
    php8.2-ldap \
    php8.2-mbstring \
    php8.2-mysql \
    php8.2-pgsql \
    php8.2-soap \
    php8.2-sqlite3 \
    php8.2-xml \
    php8.2-zip \
    php8.2-intl \
    php8.2-apcu \
    php-imagick \
    # Install tools
    openssl \
    nano \
    graphicsmagick \
    imagemagick \
    ghostscript \
    mysql-client \
    postgresql-client \
    iputils-ping \
    locales \
    sqlite3 \
    ca-certificates \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update
RUN apt-get install php8.2 -y
RUN apt-get install php-xml -y
RUN apt-get install php-json -y

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set locales
RUN locale-gen en_US.UTF-8 en_GB.UTF-8 de_DE.UTF-8 es_ES.UTF-8 fr_FR.UTF-8 it_IT.UTF-8 km_KH sv_SE.UTF-8 fi_FI.UTF-8

# Configure apache
RUN a2enmod rewrite expires headers
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/servername.conf
RUN a2enconf servername

# Configure vhost for TYPO3
EXPOSE 80 92 443

# Vialma configurations
COPY apache2 /etc/apache2
COPY php.ini /etc/php/8.2/apache2/php.ini
# for testing purpose, as tests run in a cli environment
COPY php.ini /etc/php/8.2/cli/php.ini

RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer
RUN chmod a+x php-cs-fixer
RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer

WORKDIR /var/www/api

HEALTHCHECK --interval=5s --timeout=3s --retries=3 CMD curl -f http://localhost || exit 1

CMD service php8.2-fpm start && apachectl -D FOREGROUND
