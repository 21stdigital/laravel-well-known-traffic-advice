<?php

use TFD\WellKnownTrafficAdvice\DataTransferObjects\TrafficAdviceItem;

describe('TrafficAdviceItem', function () {
    it('creates a valid item with disallow', function () {
        $item = new TrafficAdviceItem('test-agent', disallow: true);

        expect($item->user_agent)->toBe('test-agent');
        expect($item->disallow)->toBe(true);
        expect($item->fraction)->toBeNull();
    });

    it('creates a valid item with fraction', function () {
        $item = new TrafficAdviceItem('test-agent', fraction: 0.5);

        expect($item->user_agent)->toBe('test-agent');
        expect($item->fraction)->toBe(0.5);
        expect($item->disallow)->toBeNull();
    });

    it('throws exception for empty user agent', function () {
        expect(fn() => new TrafficAdviceItem(''))->toThrow(InvalidArgumentException::class);
        expect(fn() => new TrafficAdviceItem('   '))->toThrow(InvalidArgumentException::class);
    });

    it('throws exception when both fraction and disallow are set', function () {
        expect(fn() => new TrafficAdviceItem('test-agent', fraction: 0.5, disallow: true))
            ->toThrow(InvalidArgumentException::class);
    });

    it('throws exception when neither fraction nor disallow are set', function () {
        expect(fn() => new TrafficAdviceItem('test-agent'))
            ->toThrow(InvalidArgumentException::class);
    });

    it('throws exception for invalid fraction values', function () {
        expect(fn() => new TrafficAdviceItem('test-agent', fraction: -0.1))
            ->toThrow(InvalidArgumentException::class);
        expect(fn() => new TrafficAdviceItem('test-agent', fraction: 1.1))
            ->toThrow(InvalidArgumentException::class);
    });

    it('converts to array correctly with disallow', function () {
        $item = new TrafficAdviceItem('test-agent', disallow: true);
        $array = $item->toArray();

        expect($array)->toBe([
            'user_agent' => 'test-agent',
            'disallow' => true,
        ]);
    });

    it('converts to array correctly with fraction', function () {
        $item = new TrafficAdviceItem('test-agent', fraction: 0.75);
        $array = $item->toArray();

        expect($array)->toBe([
            'user_agent' => 'test-agent',
            'fraction' => 0.75,
        ]);
    });
});