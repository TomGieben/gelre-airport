<?php

namespace App\Models\Pivots;

use App\Models\BaseModel;

class CheckinCompany extends BaseModel
{
    protected string $table = 'IncheckenMaatschappij';
    protected array $primaryKey = [
        'maatschappijcode',
        'balienummer'
    ];
    protected array $columns = [
        'maatschappijcode',
        'balienummer'
    ];
}
