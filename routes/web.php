<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BackgroundJobController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/jobs', [BackgroundJobController::class, 'index'])->name('admin.jobs.index');
Route::post('/admin/jobs/{job}/retry', [BackgroundJobController::class, 'retry'])->name('admin.jobs.retry');

