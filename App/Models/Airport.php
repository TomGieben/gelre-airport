<?php

namespace App\Models;

use App\Models\BaseModel;

class Airport extends BaseModel
{
    protected string $table = 'Luchthaven';
    protected string $primaryKey = 'luchthavencode';
    protected array $columns = [
        'luchthavencode',
        'naam',
        'land'
    ];
}