<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExampleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $param1;
    protected $param2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($param1, $param2)
    {
        $this->param1 = $param1;
        $this->param2 = $param2;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function execute()
    {
        // Simulate a background task
        Log::channel('background_jobs')->info('ExampleJob is running with parameters:', [
            'name' => $this->param1,
            'identification' => $this->param2
        ]);

        // Simulate some processing delay
        sleep(2);

        Log::channel('background_jobs')->info('ExampleJob completed successfully.');
    }
}
