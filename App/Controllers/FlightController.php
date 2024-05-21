<?php

namespace App\Controllers;

use App\Helpers\Request;
use App\Models\Flight;

class FlightController
{
    public static function index(Request $request)
    {
        var_dump(Flight::query()->find([
            'vluchtnummer' => 28761
        ]));
    }
}
