FROM node:22.7.0 AS base

WORKDIR /var/project

############################################################################################

FROM base AS local

EXPOSE 8090

############################################################################################

FROM base AS build-stage

COPY ./ /var/project

#RUN apt-get update \
#    && npm install --no-progress -g npm@10.8 \
#    && npm install --no-progress

############################################################################################

FROM build-stage AS develop

EXPOSE 8090

# Expose the port Vite runs on
EXPOSE 3000

CMD ["npm", "run", "dev"]

############################################################################################

FROM build-stage AS build

# RUN npm run build
CMD ["npm", "run", "build"]

##############################################

#FROM nginx:1.25.1-alpine as production
#
#ADD ./docker/node/project-nginx.conf /etc/nginx/conf.d/default.conf
#
#COPY --from=build /var/project/dist /usr/share/nginx/html
#
#EXPOSE 80
#
#CMD ["nginx", "-g", "daemon off;"]