<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Request;
use App\Helpers\View;
use App\Models\Flight;
use App\Models\Passenger;

class UserController
{
    public static function flights()
    {
        $passenger = Passenger::query()->find([
            'passagiernummer' => Auth::user()->id,
        ]);

        $flightNumber = $passenger->vluchtnummer;

        $flights = Flight::query()->raw("SELECT * FROM Vlucht WHERE vluchtnummer = :flightnumber", [
            'flightnumber' => $flightNumber,
        ]);

        return new View('flight-info', [
            'flights' => $flights,
        ]);
    }
}
