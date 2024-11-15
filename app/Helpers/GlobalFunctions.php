<?php

use App\Services\BackgroundJobRunner;

if (!function_exists('runBackgroundJob')) {
    function runBackgroundJob($class, $method, $parameters = [])
    {
        $osCommand = PHP_OS_FAMILY === 'Windows' ? 'start /B ' : 'nohup ';
        $command = $osCommand . 'php artisan job:run ' . escapeshellarg($class) . ' ' . escapeshellarg($method) . ' ' . escapeshellarg(json_encode($parameters)) . ' > /dev/null 2>&1 &';

        exec($command);
    }
}
