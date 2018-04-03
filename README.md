## Install

### Setup dependencies
```shell
composer install
```

### Setup database
```shell
docker-compose up
bin/console doctrine:database:create --if-not-exists
bin/console doctrine:migrations:migrate
```

### Generate JWT keys
```shell
// the passphrase used must be the same as the one in the ".env" file
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

### Create user

```shell
bin/console app:create-user test@test.fr test
```
