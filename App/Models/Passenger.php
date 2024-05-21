<?php

namespace App\Models;

use App\Models\BaseModel;

class Passenger extends BaseModel
{
    protected string $table = 'Passagier';
    protected array $primaryKey = ['passagiernummer'];
    protected array $columns = [
        'passagiernummer',
        'naam',
        'vluchtnummer',
        'geslacht',
        'balienummer',
        'stoel',
        'inchecktijdstip',
    ];
}
