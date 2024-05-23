<?php

namespace App\Controllers;

use App\Helpers\Request;
use App\Helpers\Response;
use App\Helpers\View;
use App\Models\Counter;
use App\Models\Passenger;
use App\Models\User;

class AuthController
{
    public static function show()
    {
        return new View('auth/login');
    }

    public static function login(Request $request)
    {
        $parameters = $request->getRequestParameters();

        if (!isset($parameters['number']) || !isset($parameters['password']) || !is_numeric($parameters['number'])) {
            return new View('auth/login');
        }

        if (!isset($parameters['type']) || !in_array($parameters['type'], ['employee', 'passenger'])) {
            return new View('auth/login');
        }

        if ($parameters['type'] === 'employee') {
            self::loginEmployee($parameters);
        } elseif ($parameters['type'] === 'passenger') {
            self::loginPassenger($parameters);
        }

        $_SESSION['auth_type'] = $parameters['type'];

        return Response::redirect('/');
    }

    public static function logout()
    {
        session_destroy();

        return Response::redirect(Response::LOGIN_ROUTE);
    }

    private static function loginPassenger(array $parameters)
    {
        $user = User::query()->raw('SELECT * FROM Passagier WHERE passagiernummer = :number AND wachtwoord = :password', [
            'number' => $parameters['number'],
            'password' => $parameters['password']
        ]);

        $_SESSION['user_id'] = isset($user[0]) ? $user[0]->passagiernummer : null;
    }

    private static function loginEmployee(array $parameters)
    {
        $user = Counter::query()->raw('SELECT * FROM Balie WHERE balienummer = :number AND wachtwoord = :password', [
            'number' => $parameters['number'],
            'password' => $parameters['password']
        ]);

        if (!$user) {
            return new View('auth/login');
        }

        $_SESSION['user_id'] = isset($user[0]) ? $user[0]->balienummer : null;
    }
}
