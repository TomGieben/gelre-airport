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

        $perPage = 10;
        $page = $request->get('page', 1);

        $passengers = Passenger::query()
            ->paginate($perPage, $page)
            ->raw("SELECT * FROM Passagier ORDER BY passagiernummer DESC");

        $total = Passenger::query()->raw("SELECT COUNT(*) as count FROM Passagier")[0]->count;

        $paginator = new Paginator($perPage, $page, $total);

        return new View('passengers', [
            'passengers' => $passengers,
            'paginator' => $paginator,
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

        if (!self::validate($parameters)) {
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

    private static function validate(array $parameters): bool
    {
        if (!isset(
            $parameters['name'],
            $parameters['flightnumber'],
            $parameters['gender'],
            $parameters['counter'],
            $parameters['seat'],
            $parameters['checkin'],
            $parameters['password'],
            $parameters['password_confirm']
        )) {
            Error::add('Niet alle velden zijn ingevuld.');

            return false;
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $parameters['password'])) {
            Error::add('Het wachtwoord moet minimaal 8 karakters lang zijn en minimaal 1 hoofdletter, 1 kleine letter en 1 cijfer bevatten.');

            return false;
        }

        if ($parameters['password'] !== $parameters['password_confirm']) {
            Error::add('De wachtwoorden komen niet overeen.');

            return false;
        }

        $seat = Passenger::query()->raw("SELECT COUNT(*) as count FROM Passagier WHERE stoel = :seat AND vluchtnummer = :flightnumber", [
            'seat' => $parameters['seat'],
            'flightnumber' => $parameters['flightnumber'],
        ])[0]->count;

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
