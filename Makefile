http:
	cd public && php -S 127.0.0.1:7919
server:
	php bin/console app:server:start -vvv