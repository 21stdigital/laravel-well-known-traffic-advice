<?php

namespace TFD\WellKnownTrafficAdvice\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use TFD\WellKnownTrafficAdvice\WellKnownTrafficAdviceServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            WellKnownTrafficAdviceServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app) {}
}
