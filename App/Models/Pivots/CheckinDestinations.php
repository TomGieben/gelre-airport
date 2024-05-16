<?php

namespace App\Models\Pivots;

use App\Models\BaseModel;

class CheckinDestinations extends BaseModel
{
    protected string $table = 'IncheckenBestemming';
    protected array $primaryKey = [
        'luchthavencode',
        'balienummer'
    ];
    protected array $columns = [
        'luchthavencode',
        'balienummer'
    ];
}