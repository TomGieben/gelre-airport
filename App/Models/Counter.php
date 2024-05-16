<?php

namespace App\Models;

use App\Models\BaseModel;

class Counter extends BaseModel
{
    protected string $table = 'Balie';
    protected string $primaryKey = 'balienummer';
    protected array $columns = [
        'balienummer'
    ];
}