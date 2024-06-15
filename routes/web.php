<?php

use App\Controllers\AuthController;
use App\Controllers\FlightController;
use App\Controllers\LuggageController;
use App\Controllers\PassengerController;
use App\Controllers\SeederController;
use App\Controllers\UserController;
use App\Controllers\WelcomeController;
use App\Helpers\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/flights', [FlightController::class, 'index']);
Route::get('/flights/create', [FlightController::class, 'create']);
Route::post('/flights/store', [FlightController::class, 'store']);

Route::get('/luggage', [LuggageController::class, 'index']);
Route::post('/luggage', [LuggageController::class, 'store']);

Route::get('/flight-info', [UserController::class, 'flights']);

Route::get('/passengers', [PassengerController::class, 'index']);
Route::get('/passengers/create', [PassengerController::class, 'create']);
Route::post('/passengers/store', [PassengerController::class, 'store']);

// Auth routes
Route::get('/login', [AuthController::class, 'show'], false);
Route::post('/login', [AuthController::class, 'login'], false);
Route::post('/logout', [AuthController::class, 'logout']);

// This route is only used for development purposes
// Route::get('/seeder', [SeederController::class, 'index'], false);
