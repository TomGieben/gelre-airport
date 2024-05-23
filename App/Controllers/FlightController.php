<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Request;
use App\Helpers\View;
use App\Models\Airport;
use App\Models\Company;
use App\Models\Flight;
use App\Models\Gate;

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

    public static function create()
    {
        Auth::user()->redirectIfNotEmployee();

        $airports = Airport::query()->all();
        $gates = Gate::query()->all();
        $companies = Company::query()->all();

        return new View('flight-create', [
            'airports' => $airports,
            'gates' => $gates,
            'companies' => $companies,
        ]);
    }

    public static function store(Request $request)
    {
        Auth::user()->redirectIfNotEmployee();

        $parameters = $request->getRequestParameters();
        $date = date('Y-m-d H:i:s', strtotime($parameters['departure']));
        $flightNumber = Flight::query()->raw("SELECT MAX(vluchtnummer) as max FROM Vlucht")[0]->max + 1;

        if (!self::validate($parameters)) {
            return self::create();
        }

        Flight::query()->create([
            'vluchtnummer' => $flightNumber,
            'bestemming' => $parameters['airport'],
            'gatecode' => $parameters['gate'],
            'maatschappijcode' => $parameters['company'],
            'vertrektijd' => $date,
            'max_aantal' => $parameters['max_amount'],
            'max_gewicht_pp' => $parameters['max_weight_pp'],
            'max_totaalgewicht' => $parameters['max_weight_total'],
        ]);

        return header('Location: /flights')
    }

    private static function validate(array $parameters): bool
    {
        if (!isset(
            $parameters['airport'],
            $parameters['gate'],
            $parameters['company'],
            $parameters['departure'],
            $parameters['max_amount'],
            $parameters['max_weight_pp'],
            $parameters['max_weight_total']
        )) {
            return false;
        }

        if (
            !is_numeric($parameters['max_amount'])
            || !is_numeric($parameters['max_weight_pp'])
            || !is_numeric($parameters['max_weight_total'])
        ) {
            return false;
        }

        return true;
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
