PHP_CONTAINER=ixia_mink

composer-install:
	@docker exec -it $(PHP_CONTAINER) bash -c "composer install"

behat-init:
	@docker exec -it $(PHP_CONTAINER) bash -c "bin/behat --init"

behat-run:
	@docker exec -it $(PHP_CONTAINER) bash -c "bin/behat"