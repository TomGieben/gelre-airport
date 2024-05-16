<?php

namespace App\Controllers;

use App\Helpers\Request;
use App\Helpers\Response;
use App\Helpers\View;

class AuthController {
    public static function showLogin()
    {
        return new View('auth/login');
    }

    public static function login(Request $request)
    {
        var_dump($request); die;
    }

    public static function showRegister()
    {
        return new View('auth/register');
    }

    public static function register(Request $request)
    {
        var_dump($request); die;
    }

    public static function logout()
    {
        session_destroy();
        
        return Response::redirect(Response::LOGIN_ROUTE);
    }
}