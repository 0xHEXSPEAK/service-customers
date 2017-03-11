#! /bin/bash

exited=$(docker ps -aq | wc -l)
dangling=$(docker images -f "dangling=true" -q | wc -l)

echo -e "_____________\nBefore clean up: "; df -h / | awk '{ print $4 }'

# remove volumes for exited containers:
if [ "$exited" -gt 0 ]; then
    docker rm -v $(docker ps -aq)
fi

# batch clean up of dangling images:
if [ "$dangling" -gt 0 ]; then
    docker rmi $(docker images -f "dangling=true" -q)
fi

# batch clean up of dangling volumes:
docker volume ls -qf dangling=true | xargs -r docker volume rm

# remove exited containers:
docker ps --filter status=dead --filter status=exited -aq | xargs -r docker rm -v

# remove unused images:
docker images --no-trunc | grep '<none>' | awk '{ print $3 }' | xargs -r docker rmi

echo -e "_____________\nAfter clean up: "; df -h / | awk '{ print $4 }'

