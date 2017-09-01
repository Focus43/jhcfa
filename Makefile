export COMPOSE_PROJECT_NAME = jhcfa
SHELL = /bin/bash

.PHONY: start stop

all:

start:
	docker-compose -f docker/compose.yml up -d
	docker-compose -f docker/compose.yml logs -f; true && \
	make stop

stop:
	docker-compose -f docker/compose.yml down