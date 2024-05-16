<?php

namespace App\Models;

use App\Models\BaseModel;

class Counter extends BaseModel
{
    protected string $table = 'BagageObject';
    protected array $primaryKey = [
        'passagiersnummer',
        'objectvolgnummer'
    ];
    protected array $columns = [
        'passagiersnummer',
        'objectvolgnummer',
        'gewicht'
    ];
}