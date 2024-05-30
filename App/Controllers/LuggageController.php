<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Paginator;
use App\Helpers\Request;
use App\Helpers\View;
use App\Models\Flight;
use App\Models\Luggage;
use App\Models\Passenger;

class LuggageController
{
    public static function index(Request $request)
    {
        $passengers = [];
        $perPage = 10;
        $page = $request->get('page', 1);

        if (Auth::user()->isPassenger()) {
            $passengerNumber = Auth::user()->id;

            $luggage = Luggage::query()
                ->paginate($perPage, $page)
                ->raw("SELECT * FROM BagageObject WHERE passagiernummer = :passagiernummer ORDER BY passagiernummer", [
                    'passagiernummer' => $passengerNumber,
                ]);

            $total = Luggage::query()->raw("SELECT COUNT(*) as count FROM BagageObject WHERE passagiernummer = :passagiernummer", [
                'passagiernummer' => $passengerNumber,
            ])[0]->count;
        } else {
            $luggage = Luggage::query()
                ->paginate($perPage, $page)
                ->all();

            $passengers = Passenger::query()->raw(
                "SELECT 
                    Passagier.passagiernummer, 
                    Passagier.naam, 
                    Passagier.vluchtnummer 
                FROM Passagier 
                INNER JOIN Vlucht 
                    ON Passagier.vluchtnummer = Vlucht.vluchtnummer
                    AND Vlucht.vertrektijd > GETDATE();"
            );

            $total = Luggage::query()->raw("SELECT COUNT(*) as count FROM BagageObject")[0]->count;
        }

        $paginator = new Paginator($perPage, $page, $total);

        return new View('luggage', [
            'luggage' => $luggage,
            'passengers' => $passengers,
            'paginator' => $paginator,
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

        $prevFollowNumber = Luggage::query()->raw("SELECT MAX(objectvolgnummer) as max FROM BagageObject WHERE passagiernummer = :passagiernummer", [
            'passagiernummer' => $passengerNumber,
        ]);

        $heighestFollowNumber = $prevFollowNumber[0]->max + 1;

        $maxWeightOfFlight = Flight::query()->raw(
            "SELECT
                V.max_totaalgewicht
            FROM dbo.Passagier AS P
            INNER JOIN Vlucht AS V
                ON V.vluchtnummer = P.vluchtnummer
            WHERE P.passagiernummer = :passagiernummer",
            [
                'passagiernummer' => $passengerNumber,
            ]
        )[0]->max_totaalgewicht;

        $totalWeightOfLuggage = Luggage::query()->raw(
            "SELECT
                SUM(B.gewicht) as total
            FROM dbo.BagageObject AS B
            INNER JOIN Passagier AS P
                ON B.passagiernummer = P.passagiernummer
            INNER JOIN Vlucht AS V
                ON P.vluchtnummer = V.vluchtnummer
                AND V.vluchtnummer = (
                    SELECT vluchtnummer 
                    FROM Passagier 
                    WHERE passagiernummer = :passagiernummer
                )",
            [
                'passagiernummer' => $passengerNumber,
            ]
        )[0]->total;

        if (($totalWeightOfLuggage + (float)$parameters['weight']) > $maxWeightOfFlight) {
            return self::index($request);
        }

        $luggage = Luggage::query()->create([
            'passagiernummer' => $passengerNumber,
            'objectvolgnummer' => $heighestFollowNumber,
            'gewicht' => (float)$parameters['weight'],
        ]);

        return header('Location: /luggage');
    }
}
