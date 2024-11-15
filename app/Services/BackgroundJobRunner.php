<?php

namespace App\Services;

use App\Models\BackgroundJob;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class BackgroundJobRunner
{
    public static function execute($class, $method, $parameters = [], $retryAttempts = null)
{
    $retryAttempts = $retryAttempts ?? config('background_jobs.retry_attempts');
    $attempt = 0;

    do {
        try {
            $instance = new $class();
            return call_user_func_array([$instance, $method], $parameters);
        } catch (Exception $e) {
            $attempt++;
            Log::channel('background_errors')->error("Retry {$attempt} for {$class}@{$method} failed", [
                'parameters' => $parameters,
                'error' => $e->getMessage(),
            ]);

            if ($attempt >= $retryAttempts) {
                throw $e;
            }
        }
    } while ($attempt < $retryAttempts);
}

public static function queueJob($class, $method, $parameters = [], $priority = 1)
    {
        return BackgroundJob::create([
            'class' => $class,
            'method' => $method,
            'parameters' => $parameters,
            'priority' => $priority,
            'status' => 'pending',
        ]);
    }

    public static function processQueue()
    {
        // Fetch the next pending job, ordered by priority and creation time
        $jobRecord = DB::table('background_jobs')
            ->where('status', 'pending')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$jobRecord) {
            Log::channel('background_jobs')->info('No pending jobs in the queue.');
            
            return;
        }

        // Mark job as 'running'
        DB::table('background_jobs')
            ->where('id', $jobRecord->id)
            ->update(['status' => 'running']);

        try {
            // Decode parameters (stored as JSON)
            $parameters = json_decode($jobRecord->parameters, true);

            // Instantiate the job class dynamically
            $jobClass = "App\\Jobs\\" . $jobRecord->class;
            $method = $jobRecord->method;

            // Create an instance of the job class and pass the parameters
            $jobInstance = new $jobClass(...array_values($parameters));

            // Call the specified method on the job class
            $jobInstance->{$method}();

            // Mark job as 'completed' after successful execution
            DB::table('background_jobs')
                ->where('id', $jobRecord->id)
                ->update(['status' => 'completed']);
        } catch (\Exception $e) {
            // Log any errors and mark job as 'failed'
            Log::channel('background_errors')->error('Job failed: ' . $e->getMessage());

            DB::table('background_jobs')
                ->where('id', $jobRecord->id)
                ->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
        }
    }

}