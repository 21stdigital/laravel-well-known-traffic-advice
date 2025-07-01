<?php

namespace TFD\WellKnownTrafficAdvice\Checks;

use Illuminate\Support\Facades\Log;
use TFD\WellKnownTrafficAdvice\Contracts\TrafficAdviceCheck;

class DisallowedTimeCheck implements TrafficAdviceCheck
{
    public function shouldDisallow(): bool
    {
        $disallowedTimeRanges = config('well-known-traffic-advice.disallowed_time_ranges', []);
        $currentTime = now();

        foreach ($disallowedTimeRanges as $disallowedTimeRange) {
            $parts = explode('-', $disallowedTimeRange);

            if (count($parts) !== 2) {
                Log::warning('Invalid disallowed time range: ' . $disallowedTimeRange);
                continue;
            }

            [$startTime, $endTime] = $parts;

            $startDateTime = now()->setTimeFromTimeString($startTime);
            $endDateTime = now()->setTimeFromTimeString($endTime);

            if ($currentTime >= $startDateTime && $currentTime <= $endDateTime) {
                return true;
            }
        }

        return false;
    }

    public function getName(): string
    {
        return 'Disallowed Time Check';
    }
}
