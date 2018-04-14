## Install

### Setup dependencies

```shell
composer install
```

### Setup database

```shell
// start containers
docker-compose up

// from another terminal (except if you've used the "-d" option previously)
bin/console doctrine:database:create --if-not-exists
bin/console doctrine:migrations:migrate
```

### Generate JWT keys

```shell
// the passphrase used must be the same as the one in the ".env" file
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

### Create a user

```shell
bin/console app:create-user test@test.fr test
```

### Get a token to use the API

```shell
bin/console app:get-token test@test.fr
```
