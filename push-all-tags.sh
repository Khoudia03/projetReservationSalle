#!/bin/bash

DOCKER_USERNAME="mamicisse"
IMAGE_NAME="projetreservation"

tags=$(git tag)

for tag in v1.0.1
do
    echo "=== Traitement du tag: $tag ==="
    git checkout v1.0.1
    docker build -t mamicisse/projetreservation:v1.0.1 .
    docker push mamicisse/projetreservation:v1.0.1
    echo "=== Tag v1.0.1 pushé avec succès ==="
done

git checkout main
