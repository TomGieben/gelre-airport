<?php

namespace App\Models;

use App\Models\BaseModel;

class Flight extends BaseModel
{
    protected string $table = 'flight';
    protected string $primaryKey = 'vluchtnummer';
    protected array $columns = [
        'vluchtnummer',
        'bestemming',
        'gatecode',
        'max_aantal',
        'max_gewicht_pp',
        'max_totaalgewicht',
        'vertrektijd',
        'maatschappijcode',
    ];
}