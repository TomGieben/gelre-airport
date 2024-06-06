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

        $passengers = Passenger::query()->all();

        if (empty($passengers)) {
            return;
        }

        foreach ($passengers as $passenger) {
            if (password_verify($passenger->wachtwoord, $passenger->wachtwoord)) {
                continue;
            }

            $password = password_hash($passenger->wachtwoord, PASSWORD_DEFAULT);

            Passenger::query()->raw(
                "UPDATE Passagier SET
                    wachtwoord = :wachtwoord
                WHERE passagiernummer = :passagiernummer",
                [
                    'wachtwoord' => $password,
                    'passagiernummer' => $passenger->passagiernummer,
                ]
            );
        }

        $counters = Counter::query()->all();

        if (empty($counters)) {
            return;
        }

        foreach ($counters as $counter) {
            if (password_verify($counter->wachtwoord, $counter->wachtwoord)) {
                continue;
            }

            $password = password_hash($counter->wachtwoord, PASSWORD_DEFAULT);

            Counter::query()->raw(
                "UPDATE Balie SET
                    wachtwoord = :wachtwoord
                WHERE balienummer = :balienummer",
                [
                    'wachtwoord' => $password,
                    'balienummer' => $counter->balienummer,
                ]
            );
        }
    }
}
