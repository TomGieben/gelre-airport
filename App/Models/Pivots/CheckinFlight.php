<?php

namespace App\Models\Pivots;

use App\Models\BaseModel;

class CheckinFlight extends BaseModel
{
    protected string $table = 'IncheckenVlucht';
    protected array $primaryKey = [
        'vluchtnummer',
        'balienummer'
    ];
    protected array $columns = [
        'vluchtnummer',
        'balienummer'
    ];
}
