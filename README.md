# This is my package laravel-well-known-traffic-advice

[![Latest Version on Packagist](https://img.shields.io/packagist/v/21stdigital/laravel-well-known-traffic-advice.svg?style=flat-square)](https://packagist.org/packages/21stdigital/laravel-well-known-traffic-advice)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/21stdigital/laravel-well-known-traffic-advice/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/21stdigital/laravel-well-known-traffic-advice/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/21stdigital/laravel-well-known-traffic-advice/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/21stdigital/laravel-well-known-traffic-advice/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/21stdigital/laravel-well-known-traffic-advice.svg?style=flat-square)](https://packagist.org/packages/21stdigital/laravel-well-known-traffic-advice)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require 21stdigital/laravel-well-known-traffic-advice
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-well-known-traffic-advice-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-well-known-traffic-advice-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-well-known-traffic-advice-views"
```

## Usage

```php
$wellKnownTrafficAdvice = new TFD\WellKnownTrafficAdvice();
echo $wellKnownTrafficAdvice->echoPhrase('Hello, TFD!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Stefan Gruna](https://github.com/Sm1lEE)
- [All Contributors](../../contributors)
- [Spatie](https://github.com/spatie)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
