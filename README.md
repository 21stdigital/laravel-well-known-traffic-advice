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

The upcoming Traffic Advice is a standardized way for servers to communicate their current load and access recommendations to automated clients via the `/.well-known/traffic-advice endpoint`. This helps systems like Chrome's Private Prefetch Proxy decide when and how much to prefetch from your site.

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

This is the contents of the published config file:

```
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User Agents
    |--------------------------------------------------------------------------
    |
    | List of user agents that will be recognized by the controller.
    |
    */
    'user_agents' => [
        'prefetch-proxy',
        '*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Fraction
    |--------------------------------------------------------------------------
    |
    | The fraction of the total traffic that will be allowed to pass through.
    |
    | 0.0 - 1.0
    | 0.0 = 0%
    | 0.5 = 50%
    | 1.0 = 100%
    |
    */
    'fraction' => 0.35,

    /*
    |--------------------------------------------------------------------------
    | CPU Cores
    |--------------------------------------------------------------------------
    |
    | The number of CPU cores of the server.
    | The service tries to get the number of cores from the system.
    | If it fails, the configuration value will be used.
    |
    */
    'cores' => 10,

    /*
    |--------------------------------------------------------------------------
    | CPU Usage Threshold
    |--------------------------------------------------------------------------
    |
    | The threshold of the CPU usage above which the traffic will be disallowed.
    |
    */
    'cpu_usage_threshold' => 80,

    /*
    |--------------------------------------------------------------------------
    | Retry After
    |--------------------------------------------------------------------------
    |
    | The number of seconds after which the user agent is advised to retry.
    |
    */
    'retry_after' => 60,

    /*
    |--------------------------------------------------------------------------
    | Disallowed Time Ranges
    |--------------------------------------------------------------------------
    |
    | The time ranges during which the traffic will be disallowed.
    | The time has to be given in the app timezone.
    |
    | Format: 'HH:MM-HH:MM'
    |
    */
    'disallowed_time_ranges' => [
        // '00:00-00:30',
    ],

    /*
    |--------------------------------------------------------------------------
    | Checks
    |--------------------------------------------------------------------------
    |
    | The checks that will be performed to determine if the traffic should be disallowed.
    |
    | Register your own checks by adding them to the array.
    | They must implement the TrafficAdviceCheck interface.
    |
    */
    'checks' => [
        TFD\WellKnownTrafficAdvice\Checks\HighCpuUsageCheck::class,
        TFD\WellKnownTrafficAdvice\Checks\DisallowedTimeCheck::class,
    ],
];
```

## Creating Custom Checks

You can implement your own checks to define custom criteria for traffic advice. A custom check must implement the `TrafficAdviceCheck` interface.

### Example: Custom Check

Create a new class, e.g., in `app/Checks/CustomCheck.php`:

```php
namespace App\Checks;

use Tfd\LaravelWellKnownTrafficAdvice\Contracts\TrafficAdviceCheck;
use Tfd\LaravelWellKnownTrafficAdvice\DataTransferObjects\TrafficAdviceItem;

class MyCustomCheck implements TrafficAdviceCheck
{
    public function shouldDisallow(): bool
    {
        // include your custom logic to decide, if the endpoint allows requests to your site
        $customDisallow = ...

        return $customDisallow;
    }

    public function getName(): string
    {
        return 'My Custom Check';
    }
}
```

### Registering the Check

Add your check to the `checks` array in the `config/well-known-traffic-advice.php` configuration file:

```php
'checks' => [
    // ...
    App\Checks\MyCustomCheck::class,
],
```

Your check will now be considered on every request to `/.well-known/traffic-advice`.

You can find more examples in the `src/Checks` directory.


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
