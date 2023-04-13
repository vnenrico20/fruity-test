FROM node:lts-alpine as build-stage

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

# production stage
FROM nginx:stable-alpine as production-stage

RUN mkdir /vue_app

COPY --from=build-stage /app/dist /vue_app

COPY nginx.conf /etc/nginx/nginx.conf

EXPOSE 93

CMD ["nginx", "-g", "daemon off;"]
