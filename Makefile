APP = pxdmail-codeception-example
ARGS = $(filter-out $@,$(MAKECMDGOALS))

.PHONY: up
up:
	docker-compose up -d

.PHONY: down
down:
	docker-compose down

.PHONY: stop
stop:
	docker-compose stop

.PHONY: test-run
test-run:
	docker exec -it $(APP) php vendor/bin/codecept run --steps ${ARGS}

.PHONY: bash
bash:
	docker exec -it $(APP) bash
