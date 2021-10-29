start:
	@echo 'Starting pokemon API'
	docker-compose up -d

force-start:
	@echo 'Starting pokemon API'
	docker-compose up -d --force-recreate

validate:
	@echo 'Show and validate docker compose configuration'
	docker-compose config
