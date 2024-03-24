FROM webdevops/php-nginx:8.1 as pxdmail-codeception-example

COPY . /app

EXPOSE 80

WORKDIR /app
