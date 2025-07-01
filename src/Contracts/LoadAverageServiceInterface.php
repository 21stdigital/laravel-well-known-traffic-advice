<?php

namespace TFD\WellKnownTrafficAdvice\Contracts;

interface LoadAverageServiceInterface
{
    /**
     * Returns the system load average as an array (like sys_getloadavg()).
     *
     * @return float[]
     */
    public function getLoadAverage(): array;
}
