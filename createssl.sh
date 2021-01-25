#!/bin/bash

apt update -y
apt install openssl -y
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/apache-selfsigned.key -out /etc/ssl/certs/apache-selfsigned.crt << EOF
MA
Khouribga
Khouribga
1337
camagru_1337
192.168.99.107
se7enthsky6712@gmail.com
EOF
openssl dhparam -out /etc/ssl/certs/dhparam.pem 2048 -y
echo '# from https://cipherli.st/
# and https://raymii.org/s/tutorials/Strong_SSL_Security_On_Apache2.html

SSLCipherSuite EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH
SSLProtocol All -SSLv2 -SSLv3
SSLHonorCipherOrder On
# Disable preloading HSTS for now.  You can use the commented out header line that includes
# the "preload" directive if you understand the implications.
# Header always set Strict-Transport-Security "max-age=63072000; includeSubdomains; preload"
Header always set Strict-Transport-Security "max-age=63072000; includeSubdomains"
Header always set X-Frame-Options DENY
Header always set X-Content-Type-Options nosniff
# Requires Apache >= 2.4
SSLCompression off
SSLSessionTickets Off
SSLUseStapling on
SSLStaplingCache "shmcb:logs/stapling-cache(150000)"

SSLOpenSSLConfCmd DHParameters "/etc/ssl/certs/dhparam.pem"' > /etc/apache2/conf-available/ssl-params.conf

cp /etc/apache2/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf.bak

sed -i "/ServerAdmin/c\ ServerAdmin se7enthsky6712@gmail.com\nServerName 192.168.99.107" /etc/apache2/sites-available/default-ssl.conf
sed -i "/\/etc\/ssl\/certs\/ssl-cert-snakeoil.pem/c\ SSLCertificateFile      \/etc\/ssl\/certs\/apache-selfsigned.crt" /etc/apache2/sites-available/default-ssl.conf
sed -i "/SSLCertificateKeyFile/c\ SSLCertificateKeyFile   \/etc\/ssl\/private\/apache-selfsigned.key" /etc/apache2/sites-available/default-ssl.conf
# sed -i '/# BrowserMatch "MSIE [2-6]"/c\ BrowserMatch "MSIE [2-6]" \ ' "/etc/apache2/sites-available/default-ssl.conf"
# sed -i '/#               nokeepalive ssl-unclean-shutdown /c\               nokeepalive ssl-unclean-shutdown \ ' /etc/apache2/sites-available/default-ssl.conf
# sed -i '/#               downgrade-1.0 force-response-1.0/c\               downgrade-1.0 force-response-1.0' /etc/apache2/sites-available/default-ssl.conf

echo "----- FINISHED EDITING default-ssl.conf ------"
a2enmod ssl
a2enmod headers
a2ensite default-ssl
a2enconf ssl-params
