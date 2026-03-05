<?php

spl_autoload_register(function (string $class) {
    if (strpos($class, 'Framework\\') !== 0) return;
    $file = __DIR__ . '/' . substr(str_replace('\\', '/', $class), 9) . '.php';
    if (file_exists($file)) require $file;
});
