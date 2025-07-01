<?php

use Illuminate\Support\Facades\Config;

describe('HighCpuUsageCheck', function () {
    it('returns false when CPU usage is below threshold', function () {
        Config::set('well-known-traffic-advice.cpu_usage_threshold', 80);

        $check = $this->createHighCpuUsageCheckMock(
            loadAverage: [0.5, 0.3, 0.1],
            cpuCores: 4
        );

        expect($check->shouldDisallow())->toBeFalse();
    });

    it('returns true when CPU usage is above threshold', function () {
        Config::set('well-known-traffic-advice.cpu_usage_threshold', 50);

        $check = $this->createHighCpuUsageCheckMock(
            loadAverage: [2, 1.8, 1.5],
            cpuCores: 1
        );

        expect($check->shouldDisallow())->toBeTrue();
    });
});
