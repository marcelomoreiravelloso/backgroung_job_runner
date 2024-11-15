<?php

namespace App\Http\Controllers;

use App\Models\BackgroundJob;
use Illuminate\Http\Request;

class BackgroundJobController extends Controller
{
    public function index()
    {
        $jobs = BackgroundJob::orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.jobs.index', compact('jobs'));
    }

    public function retry(BackgroundJob $job)
    {
        if ($job->status === 'failed') {
            $job->update(['status' => 'pending', 'retry_attempts' => 0]);
        }

        return redirect()->route('admin.jobs.index')->with('success', 'Job retried successfully.');
    }
}
