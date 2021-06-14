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
PAYKU_PUBLIC_TOKEN={your_public_token}
PAYKU_PRIVATE_TOKEN={your_private_token}
```

Laravel Payku automatically will set the environment URL based in your `APP_ENV` variable.
So, the only thing you need to change is `APP_ENV` your project's `.env` file

```bash
APP_ENV=local # will set https://des.payku.cl/api
```

```bash
APP_ENV=production # will set https://app.payku.cl/api
```

Anyway, if you want to override the URL in a different environment, you can set the `PAYKU_BASE_URL` key in your `.env` file

```bash
PAYKU_BASE_URL=https://des.payku.cl/api
```
or...
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
