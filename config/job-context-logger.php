<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable job context logging
    |--------------------------------------------------------------------------
    |
    | When enabled, details about the currently processed queue job are added
    | to Laravel's log context.
    |
    */
    'enabled' => env('JOB_CONTEXT_LOGGER_ENABLED', true),

    /* The context key used for the current job details. */
    'context_key' => env('JOB_CONTEXT_LOGGER_CONTEXT_KEY', 'job'),
];
