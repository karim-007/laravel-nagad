# Nagad Payment Gateway for PHP/Laravel Framework

[![Downloads](https://img.shields.io/packagist/dt/karim007/laravel-nagad)](https://packagist.org/packages/karim007/laravel-nagad)
[![Starts](https://img.shields.io/packagist/stars/karim007/laravel-nagad)](https://packagist.org/packages/karim007/laravel-nagad)

## Features

This is a php/laravel wrapper package for [Nagad MFS](https://nagad.com.bd/)

1. [Create Payment/Take to Payment Page](https://github.com/karim-007/nagad#1-create-payment)
2. [Verify Payment/Query Payment/Payment Details](https://github.com/karim-007/nagad#2-verify-payment)
3. [Refund Payment](https://github.com/karim-007/nagad#3-refund-payment)

## Requirements

- PHP >=7.4
- Laravel >= 6


## Installation

```bash
composer require karim007/laravel-nagad
```

### vendor publish (config)

```bash
php artisan vendor:publish --provider="Karim007\LaravelNagad\NagadServiceProvider"
```

After publish config file setup your credential. you can see this in your config directory nagad.php file

```
"sandbox"         => env("NAGAD_SANDBOX", true), // if true it will redirect to sandbox url
"merchant_id"     => env("NAGAD_MERCHANT_ID", ""), 
"merchant_number" => env("NAGAD_MERCHANT_NUMBER", ""),
"public_key"      => env("NAGAD_PUBLIC_KEY", ""),
"private_key"     => env("NAGAD_PRIVATE_KEY", ""),
'timezone'        => 'Asia/Dhaka', // By default 
"callback_url"    => env("NAGAD_CALLBACK_URL", "http://127.0.0.1:8000/nagad/callback"), // By default you can change it in your callback url
"response_type"   => "json" // By default json you can change response type json/html 
```

### Set .env configuration

```
NAGAD_SANDBOX=true // for production use false
NAGAD_MERCHANT_ID=""
NAGAD_MERCHANT_NUMBER=""
NAGAD_PUBLIC_KEY=""
NAGAD_PRIVATE_KEY=""
NAGAD_CALLBACK_URL=""
```

## Usage

### 1. Create Payment

```
use Karim007\LaravelNagad\Payment\Payment;

return (new Payment)->create($amount, $invoiceNumber)  // 1st parameter is amount and 2nd is unique invoice number 
```

or

```
use Karim007\LaravelNagad\Facade\NagadPayment;

return NagadPayment::create($amount, $invoiceNumber);
```

### 2. Verify Payment

```
use Karim007\LaravelNagad\Payment\Payment;

(new Payment)->verify($paymentRefId) // $paymentRefId which you will find callback URL request parameter
```

or

```
use Karim007\LaravelNagad\Facade\NagadPayment;

NagadPayment::verify($paymentRefId);
```

### 3. Refund Payment

```
use Karim007\LaravelNagad\Payment\Refund;

(new Refund)->refund($paymentRefId,$refundAmount);
```

or

```
use Karim007\LaravelNagad\Facade\NagadRefund;

NagadRefund::refund($paymentRefId,$refundAmount);
```

<span style="color: #96d0ff">Note: For the refund method, you have to pass two more parameters one is <b>reference no</b> and another
<b>reference message</b></span>

Contributions to the Nagad Payment Gateway package are welcome. Please note the following guidelines before submitting your pull
request.

- Follow [PSR-4](http://www.php-fig.org/psr/psr-4/) coding standards.
- Read Nagad API documentations first. Please contact with Nagad for their api documentation and sandbox access.

## License

This repository is licensed under the [MIT License](http://opensource.org/licenses/MIT).

Copyright 2022 [karim007](https://github.com/karim-007). We are not affiliated with Nagad and don't give any guarantee. 
