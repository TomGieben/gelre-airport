<?php

use App\Controllers\AuthController;
use App\Controllers\FlightController;
use App\Controllers\LuggageController;
use App\Controllers\PassengerController;
use App\Controllers\UserController;
use App\Controllers\WelcomeController;
use App\Helpers\Route;

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/flights', [FlightController::class, 'index']);
Route::get('/luggage', [LuggageController::class, 'index']);
Route::get('/flight-info', [UserController::class, 'flights']);
Route::get('/passengers', [PassengerController::class, 'index']);
Route::get('/user', [UserController::class, 'me']);

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'], false);
Route::post('/login', [AuthController::class, 'login'], false);
Route::get('/register', [AuthController::class, 'showRegister'], false);
Route::post('/register', [AuthController::class, 'register'], false);
Route::post('/logout', [AuthController::class, 'logout']);