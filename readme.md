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

#### Important:

Laravel Payku automatically will set the environment URL based in your `APP_ENV` key, in your `.env` project's file

For example, if you set your `APP_ENV` to `local`, it will use `https://des.payku.cl/api`

```bash
APP_ENV=local # will set https://des.payku.cl/api
```

Otherwise, if your `APP_ENV` is  on `production`, it will use `https://app.payku.cl/api`

```bash
APP_ENV=production # will set https://app.payku.cl/api
```

If you want to force a specific API URL in another environment, you can [learn how to do it](readme-changing-api-url.md)

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
