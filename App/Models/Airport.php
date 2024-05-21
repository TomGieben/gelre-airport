<?php

namespace App\Models;

use App\Models\BaseModel;

class Airport extends BaseModel
{
    protected string $table = 'Luchthaven';
    protected array $primaryKey = ['luchthavencode'];
    protected array $columns = [
        'luchthavencode',
        'naam',
        'land'
    ];
}
