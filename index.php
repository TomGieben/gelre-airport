<?php

require __DIR__ . '/vendor/autoload.php';

use App\Helpers\Database;
use App\Helpers\Route;

include __DIR__ . '/routes/web.php';
include __DIR__ . '/env.php';

session_start();

global $database;

if(!isset($env) || empty($env)) {
    die('Environment configuration not found.');
}

if(!($database instanceof Database)) {
    $database = Database::config(
        $env['DB_HOST'],
        $env['DB_USERNAME'],
        $env['DB_PASSWORD'],
        $env['DB_DATABASE']
    );
}

Route::handle();