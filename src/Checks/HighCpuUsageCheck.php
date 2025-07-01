<?php

namespace TFD\WellKnownTrafficAdvice\Checks;

use TFD\WellKnownTrafficAdvice\Contracts\TrafficAdviceCheck;
use TFD\WellKnownTrafficAdvice\Contracts\LoadAverageServiceInterface;

class HighCpuUsageCheck implements TrafficAdviceCheck
{
    protected LoadAverageServiceInterface $loadAverageService;

    /**
     * @param LoadAverageServiceInterface $loadAverageService Service to retrieve system load average (mockable for tests)
     */
    public function __construct(LoadAverageServiceInterface $loadAverageService)
    {
        $this->loadAverageService = $loadAverageService;
    }

    public function shouldDisallow(): bool
    {
        $load = $this->loadAverageService->getLoadAverage();
        $weightedLoad = $load[0] * 0.6 + $load[1] * 0.3 + $load[2] * 0.1;
        $cpuCores = $this->getCpuCores();
        $cpuUsage = 100 * $weightedLoad / $cpuCores;

        return $cpuUsage > config('well-known-traffic-advice.cpu_usage_threshold', 50);
    }

    public function getName(): string
    {
        return 'High CPU Usage Check';
    }

    /**
     * Get the number of CPU cores on the server.
     */
    protected function getCpuCores(): int
    {
        $cpuCores = 0;

        if (function_exists('shell_exec')) {
            $cpuCores = (int) shell_exec('nproc 2>/dev/null');

            if ($cpuCores < 1) {
                // Fallback for MacOS or if nproc is not available
                $cpuCores = (int) shell_exec('sysctl -n hw.ncpu 2>/dev/null');
            }
        }

        if ($cpuCores < 1) {
            $cpuCores = config('well-known-traffic-advice.cores', 1); // Conservative fallback
        }

        return $cpuCores;
    }
}
