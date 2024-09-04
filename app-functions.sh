#!/bin/bash

source ./colors.sh;

# https://docs.docker.com/compose/environment-variables/envvars/#compose_env_files
export DOCKER_PATH=/docker
export SERVER_COMPOSE_FILE_PATH=./docker/docker-compose.yml
export COMPOSE_PROJECT_NAME=abz

ENV_DIRS=(/ /nginx /php /mysql /node)

if [ -f ./docker/.env ]; then
    set -a
    source ./docker/.env
    set +a
fi

source ./.env

function makeCopyFromEnvFile()
{
    COPY_FROM_ENV=".env"

    if [[ -n "$1" ]]; then
        COPY_FROM_ENV+=".$1"
    else
        COPY_FROM_ENV+=".example"
    fi
}

# Create .env from .env.example
function env()
{
    makeCopyFromEnvFile "$1"

    cp ./$COPY_FROM_ENV ./.env
}

function dockerEnv()
{

    makeCopyFromEnvFile "$1"

    for dir in ${ENV_DIRS[@]} ; do
        cp ./$DOCKER_PATH/$dir/$COPY_FROM_ENV ./$DOCKER_PATH/$dir/.env
    done
}

function status()
{
    docker compose ps
}

function start()
{
    docker compose up -d --force-recreate --remove-orphans
    status
}

function start-production-dependents()
{
    export COMPOSE_PATH_SEPARATOR=:
    export COMPOSE_FILE=./docker/docker-compose.production.yml:./docker/docker-compose.production.dependencies.yml
    docker compose up -d --force-recreate --remove-orphans
    status
}

function stop()
{
    docker compose down --remove-orphans
}

function restart()
{
    stop
    start
}

function pull()
{
    docker compose pull --no-parallel
}

function build()
{
	  docker compose build "${@:1}"
}

function bash()
{
    echo ${@:1}

    CONTAINER="${1:-php-fpm}";

    echo "Bash in container: ${CONTAINER}"

    docker compose run --rm $CONTAINER bash
}

function artisan()
{
    docker compose run --rm php-fpm bash -c "php artisan ${@:1}"
}

function composer()
{
    docker compose run --rm php-fpm composer ${@:1}
}

function logs()
{
    docker compose logs "${@:1}"
}

function nginx-restart()
{
    docker compose exec nginx bash -c "nginx -t && nginx -s reload && service nginx restart"
}

function cc()
{
    docker compose run --rm php-fpm bash -c "php artisan optimize:clear && composer du -o"
}
