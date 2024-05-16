<?php

require __DIR__ . '/vendor/autoload.php';

use App\Helpers\Route;

include __DIR__ . '/routes/web.php';
include __DIR__ . '/env.php';

session_start();

Route::handle();