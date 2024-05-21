<?php

define('ROOT', dirname(__DIR__));
define('SLASH', DIRECTORY_SEPARATOR);

spl_autoload_register(function (string $className): void {
    $fileName = str_replace("\\", "/", $className) . '.php';

    if (file_exists($fileName)) {
        require($fileName);
    } else {
        echo "file not found {$fileName}";
    }
});
