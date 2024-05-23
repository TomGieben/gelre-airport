<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Request;
use App\Helpers\View;
use App\Models\Luggage;

class LuggageController
{
    public static function index()
    {
        $passengerNumber = Auth::user()->id;

        $luggage = Luggage::query()->raw("SELECT * FROM BagageObject WHERE passagiernummer = :passagiernummer", [
            'passagiernummer' => $passengerNumber,
        ]);

        return new View('luggage', [
            'luggage' => $luggage,
        ]);
    }

    public static function store(Request $request)
    {
        $passengerNumber = Auth::user()->id;
        $parameters = $request->getRequestParameters();

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

        return header('Location: /luggage')
    }
}
