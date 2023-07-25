# smsint-for-laravel
Integration service smsint for laravel

install:

```php
composer require icekristal/smsint-for-laravel
```

Add to config/services.php

```php
 'smsint' => [
    'token' => env('SMSINT_TOKEN'),
    'url' => env('SMSINT_URL', "https://lcab.smsint.ru/json/"),
    'version' => env('SMSINT_API_VERSION', "v1.0"),
],
```

Publish config:
```php
php artisan vendor:publish --provider="Icekristal\SmsintForLaravel\SmsintServiceProvider" --tag='config'
```

Publish migrations:
```php
php artisan vendor:publish --provider="Icekristal\SmsintForLaravel\SmsintServiceProvider" --tag='migrations'

```
