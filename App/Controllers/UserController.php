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

        $checkin = Flight::query()->raw(
            "SELECT 
                IM.balienummer AS incheckcounter,
                IB.balienummer AS bagagecounter,
                IV.balienummer AS flightcounter
            FROM Vlucht AS V
            INNER JOIN IncheckenMaatschappij AS IM
                ON V.maatschappijcode = IM.maatschappijcode
            INNER JOIN IncheckenBestemming AS IB
                ON V.bestemming = IB.luchthavencode
            INNER JOIN IncheckenVlucht AS IV
                ON V.vluchtnummer = IV.vluchtnummer
            WHERE V.vluchtnummer = :flightnumber",
            [
                'flightnumber' => $flightNumber,
            ]
        );

        return new View('flight-info', [
            'flights' => $flights,
            'checkin' => $checkin,
        ]);
    }
}
