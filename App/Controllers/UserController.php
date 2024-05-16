<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Request;
use App\Helpers\View;

class UserController
{
    public static function me(Request $request)
    {
        return new View('me', [
            'email' => Auth::user()->email,
        ]);
    }

    public static function flights(Request $request)
    {
    }
}
