FROM richarvey/nginx-php-fpm
MAINTAINER "lobsiinvok@tdohacker.org"

ADD . /usr/share/nginx/html/
ADD default.conf /etc/nginx/sites-available/default.conf

RUN find /usr/share/nginx/html/ -type d -exec chmod 775 {} \;
RUN find /usr/share/nginx/html/ -type f -exec chmod 644 {} \;
RUN chown -R root:www-data /usr/share/nginx/html/

RUN echo MUCTF{y0u_607_rc3_y34h!} > /flag
RUN chmod 644 /flag
RUN chown root:www-data /flag
