<?php

namespace TFD\WellKnownTrafficAdvice;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TFD\WellKnownTrafficAdvice\Commands\WellKnownTrafficAdviceCommand;

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
            ->hasViews()
            ->hasMigration('create_laravel_well_known_traffic_advice_table')
            ->hasCommand(WellKnownTrafficAdviceCommand::class);
    }
}
