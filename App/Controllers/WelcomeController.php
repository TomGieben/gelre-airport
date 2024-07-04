<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Request;
use App\Helpers\View;

class WelcomeController
{
    public static function index(Request $request)
    {
        $userId = Auth::user()->id;
        $type = Auth::user()->type;

        return new View('welcome', [
            'userId' => $userId,
            'type' => $type,
        ]);
    }

    public static function privacy()
    {
        return new View('privacy');
    }
}
