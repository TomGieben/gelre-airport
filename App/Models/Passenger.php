<?php

namespace App\Models;

use App\Models\BaseModel;

class Passenger extends BaseModel
{
    protected string $table = 'Passagier';
    protected string $primaryKey = 'passagiersnummer';
    protected array $columns = [
        'passagiersnummer',
        'naam',
        'vluchtnummer',
        'geslacht',
        'balienummer',
        'stoel',
        'inchecktijdstip',
    ];
}