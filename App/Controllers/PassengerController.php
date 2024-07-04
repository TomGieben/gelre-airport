<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Error;
use App\Helpers\Paginator;
use App\Helpers\Request;
use App\Helpers\View;
use App\Models\Counter;
use App\Models\Flight;
use App\Models\Passenger;

class PassengerController
{
    public static function index(Request $request)
    {
        Auth::user()->redirectIfNotEmployee();

        $searchForNumber = $request->get('number') ?? null;
        $perPage = 10;
        $page = $request->get('page', 1);

        $passengers = Passenger::query()
            ->paginate($perPage, $page)
            ->raw("
                SELECT * 
                FROM Passagier 
                " . ($searchForNumber ? 'WHERE passagiernummer = :number' : '') . "
                ORDER BY passagiernummer DESC
            ", (
                $searchForNumber ? ['number' => $searchForNumber] : []
            ));

        $total = Passenger::query()->raw("SELECT COUNT(*) as count FROM Passagier")[0]->count;

        $paginator = new Paginator($perPage, $page, $total);

        return new View('passengers', [
            'passengers' => $passengers,
            'paginator' => $paginator,
            'searchForNumber' => $searchForNumber,
        ]);
    }

    public static function create()
    {
        Auth::user()->redirectIfNotEmployee();

        $flights = Flight::query()->raw("SELECT vluchtnummer FROM Vlucht WHERE vertrektijd > :now", ['now' => date('Y-m-d H:i:s')]);
        $counters = Counter::query()->raw("SELECT balienummer FROM Balie");
        $genders = Passenger::getGenders();

        return new View('passenger-create', [
            'flights' => $flights,
            'counters' => $counters,
            'genders' => $genders,
        ]);
    }

    public static function store(Request $request)
    {
        Auth::user()->redirectIfNotEmployee();

        $parameters = $request->getRequestParameters();
        $date = date('Y-m-d H:i:s', strtotime($parameters['checkin']));
        $passengerNumber = Passenger::query()->raw("SELECT MAX(passagiernummer) as max FROM Passagier")[0]->max + 1;

        if (!self::validateCreate($parameters)) {
            return self::create();
        }

        Passenger::query()->create([
            'passagiernummer' => $passengerNumber,
            'naam' => $parameters['name'],
            'vluchtnummer' => $parameters['flightnumber'],
            'geslacht' => $parameters['gender'],
            'balienummer' => $parameters['counter'],
            'stoel' => $parameters['seat'],
            'inchecktijdstip' => $date,
            'wachtwoord' => password_hash($parameters['password'], PASSWORD_DEFAULT)
        ]);

        return header('Location: /passengers');
    }

    public static function edit(string $passenger)
    {
        Auth::user()->redirectIfNotEmployee();

        $passenger = Passenger::query()->find(['passagiernummer' => $passenger]);

        if (!$passenger) {
            return header('Location: /passengers');
        }

        $flights = Flight::query()->raw("SELECT vluchtnummer FROM Vlucht WHERE vertrektijd > :now", ['now' => date('Y-m-d H:i:s')]);
        $counters = Counter::query()->raw("SELECT balienummer FROM Balie");
        $genders = Passenger::getGenders();

        return new View('passenger-edit', [
            'passenger' => $passenger,
            'flights' => $flights,
            'counters' => $counters,
            'genders' => $genders,
        ]);
    }

    public static function update(Request $request, string $passenger)
    {
        Auth::user()->redirectIfNotEmployee();
        $parameters = $request->getRequestParameters();
        $date = date('Y-m-d H:i:s', strtotime($parameters['checkin']));

        $parameters['passenger'] = $passenger;

        if (!self::validate($parameters, true)) {
            return self::edit($passenger);
        }

        Passenger::query()->update([
            'naam' => $parameters['name'],
            'vluchtnummer' => $parameters['flightnumber'],
            'geslacht' => $parameters['gender'],
            'balienummer' => $parameters['counter'],
            'stoel' => $parameters['seat'],
            'inchecktijdstip' => $date,
        ], [
            'passagiernummer' => $passenger,
        ]);

        return header('Location: /passengers');
    }

    private static function validate(array $parameters, bool $isUpdate = false): bool
    {
        $requiredParameters = [
            'name',
            'flightnumber',
            'gender',
            'counter',
            'seat',
            'checkin'
        ];

        if (!$isUpdate) {
            $requiredParameters[] = 'password';
            $requiredParameters[] = 'password_confirm';
        }

        foreach ($requiredParameters as $param) {
            if (!isset($parameters[$param])) {
                Error::add('Niet alle velden zijn ingevuld.');
                return false;
            }
        }

        if (!$isUpdate) {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $parameters['password'])) {
                Error::add('Het wachtwoord moet minimaal 8 karakters lang zijn en minimaal 1 hoofdletter, 1 kleine letter en 1 cijfer bevatten.');

                return false;
            }

            if ($parameters['password'] !== $parameters['password_confirm']) {
                Error::add('De wachtwoorden komen niet overeen.');

                return false;
            }
        }

        if ($isUpdate) {
            $seat = Passenger::query()->raw("SELECT COUNT(*) as count FROM Passagier WHERE stoel = :seat AND vluchtnummer = :flightnumber AND passagiernummer != :passenger", [
                'seat' => $parameters['seat'],
                'flightnumber' => $parameters['flightnumber'],
                'passenger' => $parameters['passenger'],
            ])[0]->count;
        } else {
            $seat = Passenger::query()->raw("SELECT COUNT(*) as count FROM Passagier WHERE stoel = :seat AND vluchtnummer = :flightnumber", [
                'seat' => $parameters['seat'],
                'flightnumber' => $parameters['flightnumber'],
            ])[0]->count;
        }


        if ($seat > 0) {
            Error::add('Deze stoel is al bezet.');

            return false;
        }

        $maxAmountOfPeople = Flight::query()->raw("SELECT max_aantal FROM Vlucht WHERE vluchtnummer = :flightnumber", [
            'flightnumber' => $parameters['flightnumber'],
        ])[0]->max_aantal;

        $peopleOnFlight = Passenger::query()->raw("SELECT COUNT(*) as count FROM Passagier WHERE vluchtnummer = :flightnumber", [
            'flightnumber' => $parameters['flightnumber'],
        ])[0]->count;

        if ($peopleOnFlight >= $maxAmountOfPeople) {
            Error::add('Deze vlucht zit vol.');

            return false;
        }

        return true;
    }
}
