# Snappfood Api V1

## Up And Running

Please make sure you have docker in your system.

```sh
$ cp .env.example .env
$ cp .env.testing.example .env.testing
```

Please update the below values in .env file:
- CACHE_DRIVER=redis
- QUEUE_CONNECTION=redis

```sh
$ make up
```

```sh
$ docker exec snappfood_app bash -c "php artisan key:generate"
```

```sh
$ make migrate-fresh
```
---
The below commands are optional
```sh
$ make api-doc
```

```sh
$ make lint
```

```sh
$ make lint-fix
```

```sh
$ make test
```

```sh
$ make down
```
---
Links:

- phpmyadmin is available: http://localhost:8080/
- Api: http://localhost/api/v1
- Api Documentation: http://localhost/api/v1/documentation
- Github: https://github.com/farshidboroomand/snappfood