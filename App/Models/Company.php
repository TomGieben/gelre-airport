<?php

namespace App\Models;

use App\Models\BaseModel;

class Company extends BaseModel
{
    protected string $table = 'Maatschappij';
    protected array $primaryKey = ['maatschappijcode'];
    protected array $columns = [
        'maatschappijcode',
        'naam',
        'max_objecten_pp',
    ];
}
