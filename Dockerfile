FROM httpd:latest

USER root

RUN yum install php -y

USER default

COPY /sssDemo /var/www/html

#CMD tail -f /dev/null
