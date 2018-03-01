.PHONY: build install

build:
	docker-compose -f ../../../docker-compose.yaml exec php php /var/www/html/public/pkg/mspbepaid/_build/build.transport.php
install:
	docker-compose -f ../../../docker-compose.yaml exec php php /var/www/html/public/pkg/mspbepaid/_build/install.script.php
