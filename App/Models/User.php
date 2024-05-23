<?php

namespace App\Models;

use App\Models\BaseModel;

class User extends BaseModel
{
    protected string $table = 'Gebruiker';
    protected array $primaryKey = ['gebruikersnaam'];
    protected array $columns = [
        'id',
        'type',
    ];

    public function isPassenger(): bool
    {
        return $this->type === 'passenger';
    }

    public function isEmployee(): bool
    {
        return $this->type === 'employee';
    }
}
