<?php

namespace App\Controllers;

use App\Helpers\Request;
use App\Helpers\View;

class WelcomeController
{
    public static function index(Request $request)
    {
        return new View('welcome', ['name' => 'World']);
    }
}
