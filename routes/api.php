<?php

use Illuminate\Support\Facades\Route;

Route::post('/token', [\App\Http\Controllers\Api\TokenController::class, 'generate']);

Route::apiResource('/users', \App\Http\Controllers\Api\UserController::class);

Route::get('/positions', [\App\Http\Controllers\Api\PositionController::class, 'index']);
