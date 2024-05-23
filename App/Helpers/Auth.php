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
        return isset($_SESSION['user_id']);
    }

    /**
     * Get the user.
     *
     * @return User|null
     */
    public static function user(): ?User
    {
        return new User([
            'type' => $_SESSION['auth_type'],
            'id' => $_SESSION['user_id']
        ]);
    }
}
