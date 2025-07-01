<?php

namespace TFD\WellKnownTrafficAdvice;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WellKnownTrafficAdviceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-well-known-traffic-advice')
            ->hasConfigFile()
            ->hasRoute('web');
    }
}
