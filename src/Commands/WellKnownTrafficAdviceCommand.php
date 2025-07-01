<?php

namespace TFD\WellKnownTrafficAdvice\Commands;

use Illuminate\Console\Command;

class WellKnownTrafficAdviceCommand extends Command
{
    public $signature = 'laravel-well-known-traffic-advice';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
