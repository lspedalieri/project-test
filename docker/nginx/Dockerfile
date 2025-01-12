FROM nginx:1.24-alpine AS base

RUN mkdir -p /etc/ssl/private && mkdir -p /etc/ssl/certs
COPY ./docker/nginx/local-ssl.crt /etc/ssl/certs/local-ssl.crt
COPY ./docker/nginx/local-key.key /etc/ssl/certs/local.key