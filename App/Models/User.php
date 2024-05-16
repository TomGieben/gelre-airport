<?php

namespace App\Models;

use App\Models\BaseModel;

class User extends BaseModel
{
    protected string $table = 'Gebruiker';
    protected array $primaryKey = ['gebruikersnaam'];
    protected array $columns = [
        'email',
    ];
}