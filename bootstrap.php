<?php

define('BASE_PATH', __DIR__);

session_start();

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $base   = BASE_PATH . '/src/';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file     = $base . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
