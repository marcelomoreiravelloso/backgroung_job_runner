<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BackgroundJobRunner;

class RunJobCommand extends Command
{
    protected $signature = 'job:run {class} {method} {parameters?}';
    protected $description = 'Run a background job with a specific class, method, and parameters';

    public function handle()
    {
        $class = "App\\Jobs\\" .$this->argument('class');
        $method = $this->argument('method');
        $parameters = json_decode($this->argument('parameters'), true) ?? [];

        if (BackgroundJobRunner::execute($class, $method, $parameters) === false) {
            $this->error('Job failed.');
            return 1;
        }

        $this->info('Job completed successfully.');
        return 0;
    }
}
