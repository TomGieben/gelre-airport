<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Request;
use App\Helpers\View;
use App\Models\Luggage;
use App\Models\Passenger;

class LuggageController
{
    public static function index()
    {
        $passengers = [];

        if (Auth::user()->isPassenger()) {
            $passengerNumber = Auth::user()->id;

            $luggage = Luggage::query()->raw("SELECT * FROM BagageObject WHERE passagiernummer = :passagiernummer", [
                'passagiernummer' => $passengerNumber,
            ]);
        } else {
            $luggage = Luggage::query()->all();
            $passengers = Passenger::query()->all();
        }

        return new View('luggage', [
            'luggage' => $luggage,
            'passengers' => $passengers,
        ]);
    }

    public static function store(Request $request)
    {
        $passengerNumber = Auth::user()->id;
        $parameters = $request->getRequestParameters();

        if (Auth::user()->isEmployee() && isset($parameters['passenger'])) {
            $passengerNumber = $parameters['passenger'];
        }

        if (!isset($parameters['weight']) || !is_numeric($parameters['weight'])) {
            return self::index($request);
        }

        $query = Luggage::query()->raw("SELECT MAX(objectvolgnummer) as max FROM BagageObject WHERE passagiernummer = :passagiernummer", [
            'passagiernummer' => $passengerNumber,
        ]);

        $heighestFollowNumber = $query[0]->max + 1;

        $luggage = Luggage::query()->create([
            'passagiernummer' => $passengerNumber,
            'objectvolgnummer' => $heighestFollowNumber,
            'gewicht' => (float)$parameters['weight'],
        ]);

        return header('Location: /luggage');
    }
}
