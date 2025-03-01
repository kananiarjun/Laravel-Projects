<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/book/{id}', [MovieController::class, 'book']);
Route::post('/movies/book/{id}', [MovieController::class, 'confirmBooking']);
