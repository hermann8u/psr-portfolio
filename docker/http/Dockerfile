FROM registry.hub.docker.com/library/node:14.16-alpine AS node

WORKDIR /node
COPY package.json .
COPY package-lock.json .
RUN npm ci

COPY assets /node/assets
COPY postcss.config.js /node/postcss.config.js
COPY tailwind.config.js /node/tailwind.config.js
COPY webpack.config.js /node/webpack.config.js
COPY src /node/src
COPY templates /node/templates
RUN npm run build

FROM registry.hub.docker.com/library/nginx:1.19-alpine

COPY ./docker/http/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=node /node/public /var/psr-portfolio/public
COPY ./public/img /var/psr-portfolio/public/img
COPY ./public/favicon.ico /var/psr-portfolio/public/favicon.ico
COPY ./public/robots.txt /var/psr-portfolio/public/robots.txt
COPY ./public/sitemap.xml /var/psr-portfolio/public/sitemap.xml
