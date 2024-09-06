FROM nginx:latest

WORKDIR /var/project

ADD ./project-nginx.conf /etc/nginx/conf.d/default.conf
ADD ./cors.conf /etc/nginx/conf.d/cors.conf

RUN nproc
RUN lscpu
RUN ulimit -n

# RUN nginx -V
# RUN nginx -t

# RUN nginx -s reload
# RUN service nginx restart
