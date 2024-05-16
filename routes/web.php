<?php

use App\Controllers\AuthController;
use App\Controllers\WelcomeController;
use App\Helpers\Route;

Route::get('/', [WelcomeController::class, 'index']);

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'], false);
Route::post('/login', [AuthController::class, 'login'], false);
Route::get('/register', [AuthController::class, 'showRegister'], false);
Route::post('/register', [AuthController::class, 'register'], false);