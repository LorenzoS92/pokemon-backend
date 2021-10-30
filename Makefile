start:
	@echo 'Starting pokemon API'
	./vendor/bin/sail up -d

force-start:
	@echo 'Starting pokemon API'
	docker-compose up -d --force-recreate

stop:
	@echo 'Stopping pokemon API'
	./vendor/bin/sail down

share:
	@echo 'Share Pokemon Backend to public url'
	make start
	./vendor/bin/sail share

test:
	@echo 'Testing backend'
	make start
	./vendor/bin/sail test

shell:
	@echo 'Launching shell'
	make start
	./vendor/bin/sail shell
