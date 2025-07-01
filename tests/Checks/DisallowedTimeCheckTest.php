<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use TFD\WellKnownTrafficAdvice\Checks\DisallowedTimeCheck;

describe('DisallowedTimeCheck', function () {
    beforeEach(function () {
        $this->check = new DisallowedTimeCheck;
    });

    it('returns false when no disallowed time ranges are configured', function () {
        Config::set('well-known-traffic-advice.disallowed_time_ranges', []);

        expect($this->check->shouldDisallow())->toBeFalse();
    });

    it('returns true when current time is within disallowed range', function () {
        $currentTime = now()->setTime(14, 30, 0);
        $this->travelTo($currentTime);

        Config::set('well-known-traffic-advice.disallowed_time_ranges', ['14:00-15:00']);

        expect($this->check->shouldDisallow())->toBeTrue();
    });

    it('returns false when current time is outside disallowed range', function () {
        $currentTime = now()->setTime(16, 30, 0);
        $this->travelTo($currentTime);

        Config::set('well-known-traffic-advice.disallowed_time_ranges', ['14:00-15:00']);

        expect($this->check->shouldDisallow())->toBeFalse();
    });

    it('handles multiple time ranges', function () {
        $currentTime = now()->setTime(22, 30, 0);
        $this->travelTo($currentTime);

        Config::set('well-known-traffic-advice.disallowed_time_ranges', [
            '14:00-15:00',
            '22:00-23:00',
        ]);

        expect($this->check->shouldDisallow())->toBeTrue();
    });

    it('logs warning for invalid time range format', function () {
        Log::shouldReceive('warning')->once();

        Config::set('well-known-traffic-advice.disallowed_time_ranges', ['invalid-format']);

        $this->check->shouldDisallow();
    });

    it('handles time ranges crossing midnight', function () {
        $currentTime = now()->setTime(23, 30, 0);
        $this->travelTo($currentTime);

        Config::set('well-known-traffic-advice.disallowed_time_ranges', ['23:00-01:00']);

        expect($this->check->shouldDisallow())->toBeTrue();
    });
});
