<?php

namespace TFD\WellKnownTrafficAdvice\Services;

use TFD\WellKnownTrafficAdvice\Contracts\LoadAverageServiceInterface;

class LoadAverageService implements LoadAverageServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function getLoadAverage(): array
    {
        return sys_getloadavg();
    }
}
