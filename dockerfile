# y
FROM php:7.1.20-apache

#install packages
RUN apt-get update -y 2>&1 > /dev/null
RUN apt-get install -y zlib1g-dev 2>&1 > /dev/null
RUN apt-get install -y libpng-dev 2>&1 > /dev/null
RUN DEBIAN_FRONTEND=noninteractive apt install -y mailutils > /dev/null 2>&1

# install extensions
RUN docker-php-ext-install pdo 2>&1 > /dev/null
RUN docker-php-ext-install pdo_mysql 2>&1 > /dev/null
RUN docker-php-ext-install gd 2>&1 > /dev/null

RUN apt-get -y install apt-utils dialog \
    build-essential ssmtp

RUN echo 'TLS_CA_FILE=/etc/pki/tls/certs/ca-bundle.crt' >> /etc/ssmtp/ssmtp.conf
RUN echo 'root=se7enthsky6712@gmail.com' >> /etc/ssmtp/ssmtp.conf
RUN echo 'mailhub=smtp.gmail.com:587' >> /etc/ssmtp/ssmtp.conf
RUN echo 'AuthUser=se7enthsky6712@gmail.com' >> /etc/ssmtp/ssmtp.conf
RUN echo 'AuthPass=2Qg&cICYshBODG!4u%ILoNU8^' >> /etc/ssmtp/ssmtp.conf
RUN echo 'UseSTARTTLS=Yes' >> /etc/ssmtp/ssmtp.conf
RUN echo 'UseTLS=Yes' >> /etc/ssmtp/ssmtp.conf
RUN echo 'hostname=AAAA' >> /etc/ssmtp/ssmtp.conf
RUN echo 'root:se7enthsky6712@gmail.com:smtp.gmail.com:587' >> /etc/ssmtp/revaliases
RUN echo "sendmail_path=/usr/sbin/sendmail -t -i" >> /usr/local/etc/php/php.ini
RUN apt-get install -y libjpeg-dev 2>&1 > /dev/null

COPY ./createssl.sh /
RUN [ "bash", "/createssl.sh"]
