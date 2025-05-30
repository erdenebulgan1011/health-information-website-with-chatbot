<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/123', function (Request $request) {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/events', [App\Http\Controllers\EventController::class, 'getEvents']);
