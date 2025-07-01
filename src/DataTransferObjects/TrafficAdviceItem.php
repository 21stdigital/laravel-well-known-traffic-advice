<?php

namespace TFD\WellKnownTrafficAdvice\DataTransferObjects;

class TrafficAdviceItem
{
    public function __construct(
        public readonly string $user_agent,
        public readonly ?float $fraction = null,
        public readonly ?bool $disallow = null
    ) {
        if (empty(trim($user_agent))) {
            throw new \InvalidArgumentException('User agent cannot be empty');
        }

        // Exactly one of $fraction or $disallow must be set
        if (($fraction === null && $disallow === null) || ($fraction !== null && $disallow !== null)) {
            throw new \InvalidArgumentException('Exactly one of fraction or disallow must be set');
        }

        if ($fraction !== null && ($fraction < 0.0 || $fraction > 1.0)) {
            throw new \InvalidArgumentException('Fraction must be between 0.0 and 1.0');
        }

        if ($disallow !== null && ! is_bool($disallow)) {
            throw new \InvalidArgumentException('Disallow must be a boolean');
        }
    }

    public function toArray(): array
    {
        $data = [
            'user_agent' => $this->user_agent,
        ];

        if ($this->fraction !== null) {
            $data['fraction'] = $this->fraction;
        }

        if ($this->disallow !== null) {
            $data['disallow'] = $this->disallow ? true : false;
        }

        return $data;
    }
}
