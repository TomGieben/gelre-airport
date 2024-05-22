<?php

namespace App\Controllers;

use App\Helpers\Request;
use App\Helpers\View;
use App\Models\Flight;

class FlightController
{
    public static function index(Request $request)
    {
        $today = date('Y-m-d');
        $parameters = $request->getRequestParameters();

        if ($request->has('flightnumber')) {
            $flights = Flight::query()->raw("SELECT * FROM Vlucht WHERE vluchtnummer = :flightnumber AND vertrektijd >= :today", [
                'flightnumber' => $parameters['flightnumber'],
                'today' => $today,
            ]);
        } else {
            $flights = Flight::query()->raw("SELECT * FROM Vlucht WHERE vertrektijd >= :today", [
                'today' => $today,
            ]);
        }

        return new View('flights', [
            'flights' => $flights,
        ]);
    }
}
