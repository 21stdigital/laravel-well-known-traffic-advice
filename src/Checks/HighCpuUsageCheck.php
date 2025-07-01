<?php

namespace TFD\WellKnownTrafficAdvice\Checks;

use TFD\WellKnownTrafficAdvice\Contracts\TrafficAdviceCheck;

class HighCpuUsageCheck implements TrafficAdviceCheck
{
    public function shouldDisallow(): bool
    {
        $load = sys_getloadavg();
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
                // Fallback für MacOS oder falls nproc nicht verfügbar
                $cpuCores = (int) shell_exec('sysctl -n hw.ncpu 2>/dev/null');
            }
        }

        if ($cpuCores < 1) {
            $cpuCores = config('well-known-traffic-advice.cores', 1); // Konservativer Fallback
        }

        return $cpuCores;
    }
}
