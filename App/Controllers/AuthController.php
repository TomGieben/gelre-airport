<?php

namespace App\Controllers;

use App\Helpers\Request;
use App\Helpers\Response;
use App\Helpers\View;
use App\Models\Passenger;
use App\Models\User;

class AuthController
{
    public static function showLogin()
    {
        return new View('auth/login');
    }

    public static function login(Request $request)
    {
        $parameters = $request->getRequestParameters();

        if (!isset($parameters['number']) || !isset($parameters['password']) || !is_numeric($parameters['number'])) {
            return new View('auth/login');
        }

        $user = Passenger::query()->raw('SELECT * FROM Passagier WHERE passagiernummer = :number AND wachtwoord = :password', [
            'number' => $parameters['number'],
            'password' => $parameters['password']
        ]);

        if (!$user) {
            return new View('auth/login');
        }

        $_SESSION['user'] = isset($user[0]) ? $user[0]->passagiernummer : null;

        return Response::redirect('/');
    }

    public static function showRegister()
    {
        return new View('auth/register');
    }

    // public static function register(Request $request)
    // {
    //     var_dump($request);
    //     die;
    // }

    public static function logout()
    {
        session_destroy();

        return Response::redirect(Response::LOGIN_ROUTE);
    }
}
