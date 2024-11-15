<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BackgroundJobRunner;

class ProcessQueueCommand extends Command
{
    protected $signature = 'job:process-queue';
    protected $description = 'Process the background job queue';

    public function handle()
    {
        BackgroundJobRunner::processQueue();
        $this->info('Job queue processed.');
    }
}
