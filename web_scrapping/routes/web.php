<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapeController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/scrape', [ScrapeController::class, 'scrape']);