<?php

function asset(string $path): string
{
    return $_ENV['APP_URL'] . 'public/' . $path;
}

function loadEnv(string $filePath): void
{
    if (!file_exists($filePath)) {
        throw new Exception("The file $filePath does not exist");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);

        $name = trim($name);
        $value = str_replace('"', '', trim($value));

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}
