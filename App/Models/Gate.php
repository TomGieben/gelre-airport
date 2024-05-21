<?php

namespace App\Models;

use App\Models\BaseModel;

class Gate extends BaseModel
{
    protected string $table = 'Gate';
    protected array $primaryKey = ['gatecode'];
    protected array $columns = [
        'gatecode',
    ];
}
