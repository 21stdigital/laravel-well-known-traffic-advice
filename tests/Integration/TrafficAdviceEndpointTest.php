<?php

use Illuminate\Support\Facades\Config;

describe('Traffic Advice Endpoint Integration', function () {
    it('responds to the well-known endpoint', function () {
        Config::set('well-known-traffic-advice.checks', []);

        $response = $this->get('/.well-known/traffic-advice');

        expect($response->status())->toBe(200);
        expect($response->headers->get('Content-Type'))->toBe('application/traffic-advice+json');
    });

    it('returns correct JSON structure', function () {
        Config::set('well-known-traffic-advice.user_agents', ['prefetch-proxy']);
        Config::set('well-known-traffic-advice.fraction', 0.5);
        Config::set('well-known-traffic-advice.checks', []);

        $response = $this->get('/.well-known/traffic-advice');

        expect($response->json())->toBe([
            [
                'user_agent' => 'prefetch-proxy',
                'fraction' => 0.5,
            ],
        ]);
    });

    it('returns 503 when checks disallow traffic', function () {
        Config::set('well-known-traffic-advice.user_agents', ['prefetch-proxy']);
        Config::set('well-known-traffic-advice.checks', [MockCheck::class]);

        $response = $this->get('/.well-known/traffic-advice');

        expect($response->status())->toBe(503);
        expect($response->headers->get('Retry-After'))->toBe('60');
        expect($response->headers->get('Cache-Control'))->toContain('no-store');
    });

    it('handles real time-based checks', function () {
        $currentTime = now()->setTime(14, 30, 0);
        $this->travelTo($currentTime);

        Config::set('well-known-traffic-advice.user_agents', ['prefetch-proxy']);
        Config::set('well-known-traffic-advice.disallowed_time_ranges', ['14:00-15:00']);
        Config::set('well-known-traffic-advice.checks', [
            \TFD\WellKnownTrafficAdvice\Checks\DisallowedTimeCheck::class,
        ]);

        $response = $this->get('/.well-known/traffic-advice');

        expect($response->status())->toBe(503);
    });
});
