<?php

namespace App\Helpers;

class Config {
    private static array $cache = [];

    /**
     * Get the configuration for a specific key.
     * 
     * @param string $key The key to get the configuration for.
     * @return array The configuration for the key.
     * @throws \Exception If the configuration file for the key is not found.
     */
    public static function get(string $key): array
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $pieces = explode('.', $key);
        $path = __DIR__ . "/../../configs";

        foreach ($pieces as $piece) {
            $path .= "/$piece";
        }

        if (file_exists("$path.php")) {
            $config = require "$path.php";

            self::$cache[$key] = $config;

            return $config;
        }

        throw new \Exception("Configuration file for key '$key' not found");
    }

    /**
     * Clear the cache for a specific key or all keys.
     * 
     * @param string|null $key The key to clear the cache for.
     */
    public static function clearCache(string $key = null): void
    {
        if ($key !== null && isset(self::$cache[$key])) {
            unset(self::$cache[$key]);
        } elseif ($key === null) {
            self::$cache = [];
        }
    }
}
