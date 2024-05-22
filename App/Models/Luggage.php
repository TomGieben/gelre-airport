<?php

namespace App\Models;

use App\Models\BaseModel;

class Luggage extends BaseModel
{
    protected string $table = 'BagageObject';
    protected array $primaryKey = [
        'passagiernummer',
        'objectvolgnummer'
    ];
    protected array $columns = [
        'passagiernummer',
        'objectvolgnummer',
        'gewicht'
    ];
}
