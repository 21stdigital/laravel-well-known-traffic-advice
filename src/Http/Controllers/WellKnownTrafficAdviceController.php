<?php

namespace TFD\WellKnownTrafficAdvice\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TFD\WellKnownTrafficAdvice\DataTransferObjects\TrafficAdviceItem;

class WellKnownTrafficAdviceController
{
    public function __invoke(): JsonResponse
    {
        $contents = [];
        $isDisallowed = $this->shouldBeDisallowed();

        foreach (config('well-known-traffic-advice.user_agents', ['*']) as $userAgent) {
            $contents[] = new TrafficAdviceItem(
                user_agent: $userAgent,
                disallow: $isDisallowed ? true : null,
                fraction: $isDisallowed ? null : config('well-known-traffic-advice.fraction', 0.5),
            );
        }

        $responseData = array_map(fn (TrafficAdviceItem $item) => $item->toArray(), $contents);

        $response = response()->json($responseData, $this->getResponseCode($isDisallowed), [
            'Content-Type' => 'application/traffic-advice+json',
        ]);

        $this->addDisallowedHeaders($response, $isDisallowed);

        return $response;
    }

    /**
     * Check if the request should be disallowed.
     */
    protected function shouldBeDisallowed(): bool
    {
        foreach (config('well-known-traffic-advice.checks', []) as $check) {
            if (! class_exists($check)) {
                continue;
            }

            $check = app($check);

            if ($check->shouldDisallow()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add the disallowed headers to the response.
     */
    protected function addDisallowedHeaders(JsonResponse $response, bool $isDisallowed): void
    {
        if (! $isDisallowed) {
            return;
        }

        $response->headers->set('Retry-After', config('well-known-traffic-advice.retry_after', 60));
        $response->headers->set('Cache-Control', 'no-store');
    }

    /**
     * Get the response code for the traffic advice depending on the disallowed status.
     */
    protected function getResponseCode(bool $isDisallowed): int
    {
        return $isDisallowed ? 503 : 200;
    }
}
