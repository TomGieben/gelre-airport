<?php

namespace App\Helpers;

class Error
{
    public static function add(string $message): void
    {
        $_SESSION['errors'][] = $message;
    }

    public static function destroy(): void
    {
        $_SESSION['errors'] = [];
    }

    public static function show(): string
    {
        if (!isset($_SESSION['errors']) || empty($_SESSION['errors'])) {
            return '';
        }

        $html = '<div class="alert"><ul>';

        foreach ($_SESSION['errors'] as $error) {
            $html .= "<li>{$error}</li>";
        }

        $html .= '</ul></div>';

        self::destroy();

        return $html;
    }
}
