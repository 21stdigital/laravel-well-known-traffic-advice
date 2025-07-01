<?php

namespace TFD\WellKnownTrafficAdvice\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TFD\WellKnownTrafficAdvice\WellKnownTrafficAdvice
 */
class WellKnownTrafficAdvice extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \TFD\WellKnownTrafficAdvice\WellKnownTrafficAdvice::class;
    }
}
