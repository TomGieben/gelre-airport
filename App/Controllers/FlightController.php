<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Request;
use App\Helpers\View;
use App\Models\Flight;

class FlightController
{
    public static function index(Request $request)
    {
        $parameters = $request->getRequestParameters();
        $isEmployee = Auth::user()->isEmployee();
        $query = self::buildQuery($request, $parameters, $isEmployee);

        $flights = Flight::query()->raw($query);

        return new View('flights', [
            'flights' => $flights,
            'isEmployee' => $isEmployee,
        ]);
    }

    public static function buildQuery(Request $request, array $parameters, bool $isEmployee): string
    {
        $today = date('Y-m-d H:i:s');
        $query = "SELECT * FROM Vlucht WHERE 1=1 ";

        if (!$isEmployee) {
            $query .= "AND vertrektijd >= '$today' ";
        }

        if ($request->has('flightnumber') && is_numeric($parameters['flightnumber'])) {
            $flightNumber = $parameters['flightnumber'];
            $query .= "AND vluchtnummer = $flightNumber ";
        }

        if ($isEmployee) {
            if (!$request->has('with_old')) {
                $query .= "AND vertrektijd >= '$today' ";
            }

            if ($request->has('sort_airport') || $request->has('sort_time')) {
                $query .= "ORDER BY ";

                if ($request->has('sort_airport')) {
                    $query .= "bestemming, ";
                }

                if ($request->has('sort_time')) {
                    $query .= "vertrektijd, ";
                }

                $query = rtrim($query, ', ');
            }
        }

        return $query;
    }
}
