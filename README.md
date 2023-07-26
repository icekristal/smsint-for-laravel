# smsint-for-laravel
Integration service smsint for laravel

Documentation: https://lcab.smsint.ru/cabinet/json-doc/sender

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

Use SMS:
```php
use Icekristal\SmsintForLaravel\Facades\Smsint;

$phone = ["+79007778899", "+37008009900"];
$textMessage = "Test message integration for service smsint";
$service = Smsint::setRecipients($phone);
$service->setSenderName("SenderName");
$service->setMessage($textMessage);
$service->setIsOnlyValid(true); //true - no send, only check.
$service->setParams([$params]); //set no required params in documentation
$service->sendSms();

$infoStatus = Smsint::getSmsStatus(["2", "3"]);
```
