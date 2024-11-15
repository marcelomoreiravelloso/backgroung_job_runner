# Background Job Runner

A custom background job runner for Laravel, designed to execute jobs independently from the built-in queue system.

## Features
- **Background Job Execution:** Run PHP classes and methods as background jobs.
- **Error Handling and Logging:** Logs job status and errors separately.
- **Retry Mechanism:** Configurable retry attempts for failed jobs.
- **Web Dashboard:** Monitor job status, logs, and cancel jobs from a simple web interface.
- **Security:** Restricts execution to approved classes and methods.

## Installation
1. Clone the repository and navigate to the project directory.
2. Run `composer install`.
3. Copy `.env.example` to `.env` and update your database settings.
4. Run migrations: `php artisan migrate`.
5. Configure allowed classes and retry settings in `config/background_jobs.php`.

## Usage
1. To use the `runBackgroundJob` helper function, call it as shown:
   ```php
   runBackgroundJob(App\Jobs\ExampleJob::class, 'execute', ['param1', 'param2']);

