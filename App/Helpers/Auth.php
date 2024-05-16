<?php

namespace App\Helpers;

use App\Models\User;

class Auth
{
    /**
     * Check if the user is logged in.
     *
     * @return bool
     */
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Get the user.
     *
     * @return User|null
     */
    public static function user(): ?User
    {
        return new User([
            'email' => $_SESSION['user']
        ]);
    }
}
