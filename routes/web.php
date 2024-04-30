<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardController;

Route::get('/', function () {
    return view('welcome');
});

// Public route for viewing leaderboard
Route::get('/leaderboard/{tenant_id}', [LeaderboardController::class, 'show']);
