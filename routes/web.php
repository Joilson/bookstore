<?php

use App\Http\Controllers\Reports\AuthorsPerformanceController;
use Illuminate\Support\Facades\Route;

Route::get('/report/author-performance.{format}', AuthorsPerformanceController::class);

Route::get('/{any}', static function () {
    return view('app');
})->where('any', '.*');
