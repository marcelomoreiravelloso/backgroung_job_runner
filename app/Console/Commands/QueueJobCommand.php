<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BackgroundJobRunner;
use Illuminate\Support\Facades\Log;

class QueueJobCommand extends Command
{
    protected $signature = 'job:queue {class} {method} {parameters?} {--priority=1}';
    protected $description = 'Queue a background job with a priority';

    public function handle()
    {
        $class = $this->argument('class');
        $method = $this->argument('method');
        $parameters = json_decode($this->argument('parameters'), true) ?? [];
        $priority = (int)$this->option('priority');

        BackgroundJobRunner::queueJob($class, $method, $parameters, $priority);
        $msg = 'Job queued successfully [' . $class . '->' . $method . ']';
        Log::channel('background_jobs')->info($msg);
        $this->info('Job queued successfully.');
    }
}
