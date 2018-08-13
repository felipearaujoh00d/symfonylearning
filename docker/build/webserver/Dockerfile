FROM ubuntu:latest

#
#  ----> Instala pacotes gerais
#
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git-core \
        python-software-properties \
        software-properties-common \
        xvfb \
        wkhtmltopdf \
        unzip \
        locales \
        openssl \
        nano

#
#  ----> Configura locales
#
COPY config-locale.sh /opt/env-config/
RUN /opt/env-config/config-locale.sh


#
#  ---> installa o nodejs
#
RUN cd /tmp && curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs

RUN npm install babel webpack webpack-dev-server -g
RUN npm install -g less
RUN npm install uglify-js -g
RUN npm install uglifycss -g
RUN npm install bower -g



#
#  ----> Instala PHP
#
RUN LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php
RUN apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10

RUN apt-get update && apt-get install -y \
        php7.1 \
        php7.1-cli \
        php7.1-mysql \
        php7.1-curl \
        php7.1-gd \
        php7.1-imagick \
        php7.1-mcrypt \
        php7.1-xdebug \
        php7.1-cli \
        php7.1-dev \
        php7.1-intl \
        php7.1-imap \
        php7.1-json \
        php7.1-mbstring \
        php7.1-mongo \
        php7.1-xml \
        php7.1-dom \
        php7.1-readline \
        php7.1-pdo \
        php7.1-bcmath \
        apache2


RUN a2enmod rewrite && a2enmod ssl

#
# ---> realiza configurações para o PHP
COPY config-php.sh /opt/env-config/
RUN /opt/env-config/config-php.sh

#
#  ---> instala o composer
#
#WORKDIR /tmp
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer


#
# ---> configura certificados SSL
#
COPY criar-certificados.sh /opt/env-config/
RUN /opt/env-config/criar-certificados.sh

#
#  ---> configura apache (virtualhosts, portas, etc)
#
COPY ./config/apache/ports.conf /etc/apache2/
COPY ./config/apache/sites/plataforma.conf /etc/apache2/sites-available/

RUN a2dissite 000-default
RUN a2ensite plataforma

#
#  Utilizamos o supervisord para manter o apache rodando dentro do container
#
COPY apache-start.sh /opt/env-config/
#
# ---> script a ser executado quando o container for iniciado
#
COPY autostart.sh /opt/env-config/


COPY ajustar-privilegios.sh /opt/env-config/

RUN apt-get install -y supervisor
RUN mkdir -p /var/log/supervisord
COPY supervisord.conf /opt/env-config/

