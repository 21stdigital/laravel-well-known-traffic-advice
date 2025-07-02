<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User Agents
    |--------------------------------------------------------------------------
    |
    | List of user agents that will be recognized by the controller.
    |
    */
    'user_agents' => [
        'prefetch-proxy',
        '*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Fraction
    |--------------------------------------------------------------------------
    |
    | The fraction of the total traffic that will be allowed to pass through.
    |
    | 0.0 - 1.0
    | 0.0 = 0%
    | 0.5 = 50%
    | 1.0 = 100%
    |
    */
    'fraction' => 0.35,

    /*
    |--------------------------------------------------------------------------
    | CPU Cores
    |--------------------------------------------------------------------------
    |
    | The number of CPU cores of the server.
    | The service tries to get the number of cores from the system.
    | If it fails, the configuration value will be used.
    |
    */
    'cores' => 10,

    /*
    |--------------------------------------------------------------------------
    | CPU Usage Threshold
    |--------------------------------------------------------------------------
    |
    | The threshold of the CPU usage above which the traffic will be disallowed.
    |
    */
    'cpu_usage_threshold' => 80,

    /*
    |--------------------------------------------------------------------------
    | Retry After
    |--------------------------------------------------------------------------
    |
    | The number of seconds after which the user agent is advised to retry.
    |
    */
    'retry_after' => 60,

    /*
    |--------------------------------------------------------------------------
    | Disallowed Time Ranges
    |--------------------------------------------------------------------------
    |
    | The time ranges during which the traffic will be disallowed.
    | The time has to be given in the app timezone.
    |
    | Format: 'HH:MM-HH:MM'
    |
    */
    'disallowed_time_ranges' => [
        // '00:00-00:15',
    ],

    /*
    |--------------------------------------------------------------------------
    | Checks
    |--------------------------------------------------------------------------
    |
    | The checks that will be performed to determine if the traffic should be disallowed.
    |
    | Register your own checks by adding them to the array.
    | They must implement the TrafficAdviceCheck interface.
    |
    */
    'checks' => [
        TFD\WellKnownTrafficAdvice\Checks\HighCpuUsageCheck::class,
        TFD\WellKnownTrafficAdvice\Checks\DisallowedTimeCheck::class,
    ],
];
