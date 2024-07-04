<?php

header('Content-Security-Policy: default-src \'self\';');

require __DIR__ . '/autoload.php';

use App\Helpers\Database;
use App\Helpers\Route;

include __DIR__ . '/routes/web.php';
include __DIR__ . '/helpers.php';

session_start();
loadEnv(__DIR__ . '/.env');

global $database;

if (!isset($_ENV) || empty($_ENV)) {
    die('Environment configuration not found.');
}

if (!($database instanceof Database)) {
    $database = Database::config(
        $_ENV['DB_HOST'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD'],
        $_ENV['DB_DATABASE']
    );
}

Route::handle();
