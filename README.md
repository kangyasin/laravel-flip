![Laravel Flip by Kang Yasin](/docs/laravel-flip-kangyasin.png)
<p style="text-align: center;">
    <a href="https://github.com/kangyasin/laravel-flip/releases" title="Latest Stable Version">
        <img src="https://img.shields.io/github/release/kangyasin/laravel-flip.svg?style=flat-square" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/kangyasin/laravel-flip" title="Total Downloads">
        <img src="https://img.shields.io/packagist/dt/kangyasin/laravel-flip.svg?style=flat-square" alt="Total Downloads">
    </a>
    <a href="https://github.com/kangyasin/laravel-flip/actions" title="Build Status">
        <img src="https://github.com/Okipa/laravel-form-components/workflows/CI/badge.svg" alt="Build Status">
    </a>
    <a href="https://coveralls.io/github/kangyasin/laravel-flip?branch=main" title="Coverage Status">
        <img src="https://coveralls.io/repos/github/kangyasin/laravel-flip/badge.svg?branch=main" alt="Coverage Status">
    </a>
    <a href="/LICENSE.md" title="License: MIT">
        <img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License: MIT">
    </a>
</p>

**PACKAGE IN BETA-TEST : UNOFFICIAL FLIP**  

Save time and take advantage of a set of dynamical, ready-to-use.
Found this package helpful ? Please consider supporting my work!

[![Donate](https://img.shields.io/badge/Buy_me_a-Ko--fi-ff5f5f.svg)](https://ko-fi.com/kangyasin)
[![Donate](https://img.shields.io/badge/Donate_on-PayPal-green.svg)](https://paypal.me/kangyasin)

## Compatibility

| Laravel | PHP | Package |
|---|---|---|
| ^8.0 | ^8.0 | ^1.0 |

## Usage example

Just call the components you need in your views and let this package take care of the HTML generation time-consuming part.

```php
LaravelFlip::bankInquiry();
```

And get these components displayed:

![Laravel Form Components screenshot](/docs/screenshot.png)

## Table of Contents

* [Installation](#installation)
* [Configuration](#configuration)
* [Transaction](#transaction)
  * [Get Bank Support](#get-bank-support)
  * [Get City](#get-city)
  * [Get Country](#get-country)
  * [Get City and Country](#get-city-and-country)
  * [Request Bank Inquiry](#request-bank-inquiry)
  * [Idempotent Request](#idempotent-request)
  * [Create Disbursement v2](#create-disbursement-v2)
  * [Get All Disbursement v2](#get-all-disbursement-v2)
  * [Get Disbursement v2](#get-disbursement-v2)
  * [Create Disbursement v3](#create-disbursement-v3)
  * [Get All Disbursement v3](#get-all-disbursement-v3)
  * [Get Disbursement by Idempotency Key v3](#get-disbursement-by-idempotency-key-v3)
  
* [Testing](#testing)
* [Changelog](#changelog)
* [Contributing](#contributing)
* [Credits](#credits)
* [Licence](#license)

## Installation

You can install the package via composer:

```bash
composer require okipa/laravel-form-components
```

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Kangyasin\LaravelFlip\LaravelFlipServiceProvider" --tag=config
```

## Transaction

### Get Bank Support

### Get City

### Get Country

### Get City and Country

### Get Balance

### Request Bank Inquiry

### Idempotent Request

### Create Disbursement v2

### Get All Disbursement v2

### Get Disbursement v2

### Create Disbursement v3

### Get All Disbursement v3

### Get Disbursement by Idempotency Key v3

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Arthur LORENT](https://github.com/Okipa)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
