<?php

use Illuminate\Support\Facades\Config;
use TFD\WellKnownTrafficAdvice\Checks\HighCpuUsageCheck;
use TFD\WellKnownTrafficAdvice\Contracts\LoadAverageServiceInterface;

describe('Traffic Advice Feature', function () {
    it('handles normal operation without checks', function () {
        // Test normal operation
        Config::set('well-known-traffic-advice.user_agents', ['*']);
        Config::set('well-known-traffic-advice.fraction', 0.8);
        Config::set('well-known-traffic-advice.checks', []);

        $response = $this->get('/.well-known/traffic-advice');

        expect($response->status())->toBe(200);
        expect($response->json()[0]['fraction'])->toBe(0.8);
    });

    it('handles time checks', function () {
        $currentTime = now()->setTime(23, 30, 0);
        $this->travelTo($currentTime);

        Config::set('well-known-traffic-advice.user_agents', ['prefetch-proxy']);
        Config::set('well-known-traffic-advice.disallowed_time_ranges', ['23:00-00:00']);
        Config::set('well-known-traffic-advice.checks', [
            \TFD\WellKnownTrafficAdvice\Checks\DisallowedTimeCheck::class
        ]);

        $response = $this->get('/.well-known/traffic-advice');

        expect($response->status())->toBe(503);
        expect($response->json()[0]['disallow'])->toBe(true);
    });

    it('handles high load scenarios', function () {
        Config::set('well-known-traffic-advice.user_agents', ['prefetch-proxy']);
        Config::set('well-known-traffic-advice.cpu_usage_threshold', 50);
        Config::set('well-known-traffic-advice.checks', [
            \TFD\WellKnownTrafficAdvice\Checks\HighCpuUsageCheck::class
        ]);

        $check = $this->createHighCpuUsageCheckMock(
            loadAverage: [2, 1.8, 1.5],
            cpuCores: 1
        );
        $this->app->instance(HighCpuUsageCheck::class, $check);

        $response = $this->get('/.well-known/traffic-advice');

        expect($response->status())->toBe(503);
    });
});