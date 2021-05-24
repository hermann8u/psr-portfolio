FROM registry.hub.docker.com/library/node:14.16-alpine AS node

WORKDIR /node

COPY ./package.json ./
COPY ./package-lock.json ./

RUN npm ci

COPY ./assets ./
COPY ./postcss.config.js ./
COPY ./tailwind.config.js ./
COPY ./webpack.config.js ./
COPY ./src ./
COPY ./templates ./

RUN npm run build

FROM registry.hub.docker.com/library/nginx:1.19-alpine

COPY ./docker/http/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/psr-portfolio/public

COPY --from=node /node/public ./
COPY ./public/img ./
COPY ./public/favicon.ico ./
COPY ./public/robots.txt ./
COPY ./public/sitemap.xml ./
