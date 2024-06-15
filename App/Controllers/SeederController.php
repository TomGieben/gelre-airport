<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Request;
use App\Helpers\View;
use App\Models\Counter;
use App\Models\Passenger;

class SeederController
{
    /**
     * Encrypt all passwords in the database, this method only used for development purposes.
     * 
     * @param Request $request
     * 
     * @return View
     */
    public static function index()
    {
        set_time_limit(0); // Prevent the script from timing out

        $toHash = 'unsafe-pass';
        $password = password_hash($toHash, PASSWORD_DEFAULT);

        Passenger::query()->raw(
            "UPDATE Passagier SET
                wachtwoord = :wachtwoord",
            [
                'wachtwoord' => $password,
            ]
        );

        Counter::query()->raw(
            "UPDATE Balie SET
                wachtwoord = :wachtwoord",
            [
                'wachtwoord' => $password
            ]
        );
    }
}
