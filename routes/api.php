<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LeadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API resource routes for LeadController
Route::apiResource('/leads', LeadController::class);
// Route::get('/leads', [LeadController::class, 'index']);
// Route::post('/leads', [LeadController::class, 'store']);
// // Route::get('/leads/{id}', [LeadController::class, 'show']);
// Route::put('/leads/{id}', [LeadController::class, 'update']);
// Route::delete('/leads/{id}', [LeadController::class, 'destroy']);
