# Elastifeed collector system

**!!! DEVELOPMENT !!!** deployment of the central collector system

## Installation
First copy the example `.env.example` file and fill the database credentials
```bash
cp .env.example .env
vim .env
```
Then execute:
```bash
composer install
php artisan key:generate
php artisan migrate
php artisan passport:install
```

## Run a PHP development Server
```bash
php artisan cache:clear
php artisan serve
```

## Endpoints
### `/api/v1/register`
Allows for user registration. Requires a `POST` request containing the following fields:
- **email** \
    unique, max-length 255
- **password** \
    between 5 and 32 chars
- **name** \
    max-length 255
    
### `/api/v1/login`
Endpoint to log into the system.
A successful request will return a [`JWT`](https://tools.ietf.org/html/rfc7519) which grants access to all other endpoints.
Requires a `POST` request containing the following fields:
- email
- password

### `/api/v1/me`
Returns the current authenticated user object. 