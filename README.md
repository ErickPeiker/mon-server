# Owl Server

Back-end api for monitoring servers and hardwares.

## Getting Started

The application is built with `Symfony` and runs with `docker-compose`.

### Prerequisites

- Git
- Docker
- Docker Compose

### Installing

Clone the repository

```
git clone https://bitbucket.org/owl-monitoramento/owl-server.git
```

***For windows***
You must execute these commands inside the container doing:

```
docker-compose exec app bash
```

Build the containers

```
make up
```

Install dependencies

```
make install
```

Build application

```
make create build
```

Access the API by entering URL

```
http://localhost:8081/
```

***Optional:***
Seed data

```
make seed
```

### Login

Logs in and returns a JWT Token.

**URL**

`/login`

**Method:**

`POST`

**Data Params**

`email=[string]`
`password=[string]`
