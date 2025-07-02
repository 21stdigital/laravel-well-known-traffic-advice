# Laravel Traffic Advice — Standardized Server Load & Access Recommendations via `.well-known/traffic-advice`

[![Latest Version on Packagist](https://img.shields.io/packagist/v/21stdigital/laravel-well-known-traffic-advice.svg?style=flat-square)](https://packagist.org/packages/21stdigital/laravel-well-known-traffic-advice)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/21stdigital/laravel-well-known-traffic-advice/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/21stdigital/laravel-well-known-traffic-advice/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/21stdigital/laravel-well-known-traffic-advice/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/21stdigital/laravel-well-known-traffic-advice/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/21stdigital/laravel-well-known-traffic-advice.svg?style=flat-square)](https://packagist.org/packages/21stdigital/laravel-well-known-traffic-advice)

This package provides a standardized endpoint for exposing server traffic and load advice, following the emerging `.well-known` convention. It enables your Laravel application to communicate current server load, maintenance windows, or other traffic-related recommendations to automated clients, crawlers, or partner services. This helps external systems make informed decisions about when to access your application, improving reliability and reducing unnecessary load during peak times or scheduled downtimes.

Key features include:
- Customizable checks for server load, CPU usage, and disallowed access times.
- Easy integration with your existing Laravel application.
- Extensible architecture for adding your own traffic advice logic.
- Simple configuration and usage, following Laravel best practices.

## Background: What is traffic advice?

The upcoming Traffic Advice is a standardized way for servers to communicate their current load and access recommendations to automated clients via the `/.well-known/traffic-advice endpoint`. This helps systems like Chrome’s Private Prefetch Proxy decide when and how much to prefetch from your site.

By providing information such as server load, allowed prefetch fractions, or disallowing access during maintenance, Traffic Advice helps optimize resource usage and improve reliability. It enables sites to control automated traffic dynamically, reducing unnecessary load during peak times while enhancing user experience when capacity allows.

Implementing this endpoint allows your application to participate in smarter, automated traffic management, benefiting both your server and clients.

## Installation

You can install the package via composer:

```bash
composer require tfd/laravel-well-known-traffic-advice
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-well-known-traffic-advice-config"
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
