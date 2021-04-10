FROM registry.hub.docker.com/library/node:14.16-alpine AS node

WORKDIR /node
COPY package.json .
COPY package-lock.json .
RUN npm install
# replace with npm ci

COPY assets /node/assets
COPY postcss.config.js /node/postcss.config.js
COPY tailwind.config.js /node/tailwind.config.js
COPY webpack.config.js /node/webpack.config.js
COPY src /node/src
COPY templates /node/templates
RUN pwd && ls -la && npm run build

FROM registry.hub.docker.com/library/nginx:1.19-alpine

COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=node /node/public /var/psr-portfolio/public
