<?php

return [
    'retry_attempts' => 3,
    'log_file' => storage_path('logs/background_jobs.log'),
    'error_log_file' => storage_path('logs/background_jobs_errors.log'),
    'allowed_classes' => [
        \App\Jobs\ExampleJob::class,
    ],
];
