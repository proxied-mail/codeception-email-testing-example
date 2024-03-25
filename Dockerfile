FROM webdevops/php-nginx:8.3 as pxdmail-codeception-example

COPY . /app

EXPOSE 80

WORKDIR /app
