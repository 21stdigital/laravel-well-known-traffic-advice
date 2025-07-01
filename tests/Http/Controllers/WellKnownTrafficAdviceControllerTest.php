<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use TFD\WellKnownTrafficAdvice\Http\Controllers\WellKnownTrafficAdviceController;

describe('WellKnownTrafficAdviceController', function () {
    beforeEach(function () {
        $this->controller = new WellKnownTrafficAdviceController;
    });

    it('returns 200 with fraction when no checks disallow', function () {
        $testUserAgent = 'test-agent';
        $testFraction = 0.5;

        Config::set('well-known-traffic-advice.user_agents', [$testUserAgent]);
        Config::set('well-known-traffic-advice.fraction', $testFraction);
        Config::set('well-known-traffic-advice.checks', []);

        $response = $this->controller->__invoke();

        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())->toBe(200);
        expect($response->getData(true))->toBe([
            [
                'user_agent' => $testUserAgent,
                'fraction' => $testFraction,
            ],
        ]);
        expect($response->headers->get('Content-Type'))->toBe('application/traffic-advice+json');
    });

    it('returns 503 with disallow when checks fail', function () {
        Config::set('well-known-traffic-advice.user_agents', ['test-agent']);
        Config::set('well-known-traffic-advice.checks', [MockCheck::class]);

        $response = $this->controller->__invoke();

        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())->toBe(503);
        expect($response->getData(true))->toBe([
            [
                'user_agent' => 'test-agent',
                'disallow' => true,
            ],
        ]);
    });

    it('handles multiple user agents', function () {
        Config::set('well-known-traffic-advice.user_agents', ['agent1', 'agent2']);
        Config::set('well-known-traffic-advice.fraction', 0.3);
        Config::set('well-known-traffic-advice.checks', []);

        $response = $this->controller->__invoke();

        expect($response->getData(true))->toBe([
            [
                'user_agent' => 'agent1',
                'fraction' => 0.3,
            ],
            [
                'user_agent' => 'agent2',
                'fraction' => 0.3,
            ],
        ]);
    });

    it('skips non-existent check classes', function () {
        Config::set('well-known-traffic-advice.user_agents', ['test-agent']);
        Config::set('well-known-traffic-advice.fraction', 0.5);
        Config::set('well-known-traffic-advice.checks', ['NonExistentClass']);

        $response = $this->controller->__invoke();

        expect($response->getStatusCode())->toBe(200);
    });
});

// Mock check class for testing
class MockCheck implements \TFD\WellKnownTrafficAdvice\Contracts\TrafficAdviceCheck
{
    public function shouldDisallow(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return 'Mock Check';
    }
}
