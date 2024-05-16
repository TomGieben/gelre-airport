<?php

namespace App\Models;

use App\Models\BaseModel;

class Gate extends BaseModel
{
    protected string $table = 'Gate';
    protected string $primaryKey = 'gatecode';
    protected array $columns = [
        'gatecode',
    ];
}
