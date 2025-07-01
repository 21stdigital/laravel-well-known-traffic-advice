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

            // Must exactly contain two parts
            if (count($parts) !== 2) {
                Log::warning('Invalid disallowed time range: '.$disallowedTimeRange);

                continue;
            }

            [$startTime, $endTime] = $parts;

            // Every part must be a valid time string
            if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $startTime) ||
                !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $endTime)) {
                Log::warning('Invalid time format in disallowed time range: '.$disallowedTimeRange);

                continue;
            }

            $startDateTime = now()->setTimeFromTimeString($startTime);
            $endDateTime = now()->setTimeFromTimeString($endTime);

            if ($endDateTime < $startDateTime) {
                // Time range crosses midnight
                if ($currentTime >= $startDateTime || $currentTime <= $endDateTime) {
                    return true;
                }
            } else {
                if ($currentTime >= $startDateTime && $currentTime <= $endDateTime) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getName(): string
    {
        return 'Disallowed Time Check';
    }
}
