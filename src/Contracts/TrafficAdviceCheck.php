<?php

namespace TFD\WellKnownTrafficAdvice\Contracts;

interface TrafficAdviceCheck
{
    /**
     * Check if the request should be disallowed based on this check.
     *
     * @return bool True if the request should be disallowed, false otherwise
     */
    public function shouldDisallow(): bool;

    /**
     * Get a human-readable name for this check.
     */
    public function getName(): string;
}
