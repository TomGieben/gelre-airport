<?php

namespace App\Helpers;

class Response
{
    const LOGIN_ROUTE = '/login';

    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    /**
     * Send error response with specified code and message.
     * @param int $code The HTTP status code.
     * @param string $message The error message.
     */
    public static function error(int $code, string $message): void
    {
        header("HTTP/1.0 $code");
        echo "$code" . PHP_EOL . "$message";

        exit;
    }

    /**
     * Send 404 Not Found error response.
     */
    public static function notFound(): void
    {
        $code = 404;
        self::error($code, Config::get('responses')[$code]);
    }

    /**
     * Send 405 Method Not Allowed error response.
     */
    public static function methodNotAllowed(): void
    {
        $code = 405;
        self::error($code, Config::get('responses')[$code]);
    }

    /**
     * Send 500 Internal Server Error response.
     */
    public static function internalServerError(): void
    {
        $code = 500;
        self::error($code, Config::get('responses')[$code]);
    }

    /**
     * Send 400 Bad Request error response.
     */
    public static function badRequest(): void
    {
        $code = 400;
        self::error($code, Config::get('responses')[$code]);
    }

    /**
     * Send 401 Unauthorized error response.
     */
    public static function unauthorized(): void
    {
        $code = 401;
        self::error($code, Config::get('responses')[$code]);
    }
}
