# Laravel Payku

📦 A simple implementation, and ready to use package for Payku.

### Requirements

- Laravel 8 or above

### Installation

```bash
composer require sebacarrasco93/laravel-payku
```

#### Adding .env keys

You need to create a public and private token. You can create and get it from:
- [Payku Development environment](https://des.payku.cl/usuarios/tokenintegracion) 
- [Payku Production environment](https://app.payku.cl/usuarios/tokenintegracion)

```bash
PAYKU_BASE_URL={choose from below}
PAYKU_PUBLIC_TOKEN={your_public_token}
PAYKU_PRIVATE_TOKEN={your_private_token}
```

If you you are developing, set your {environment} variable
```bash
PAYKU_BASE_URL=https://des.payku.cl/api
``` 

If you you are in production, set your {environment} variable
```bash
PAYKU_BASE_URL=https://app.payku.cl/api
``` 

### Usage

Example of a method

```php
//
```

Easy Peasy!

### Extra

If you want more control, you can publish the migrations and configuration

```bash
php artisan vendor:publish --provider="SebaCarrasco93\LaravelPayku\LaravelPaykuServiceProvider"
```

### Testing

```bash
./vendor/bin/pest
```
