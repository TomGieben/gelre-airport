<?php

function asset(string $path): string
{
    global $env;

    return $env['APP_URL'] . 'public/' . $path;
}
