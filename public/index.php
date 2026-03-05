<?php

require __DIR__ . '/../framework/autoload.php';

spl_autoload_register(function (string $class) {
    if (strpos($class, 'App\\') !== 0) return;
    $file = __DIR__ . '/../app/' . substr(str_replace('\\', '/', $class), 4) . '.php';
    if (file_exists($file)) require $file;
});

$app = new \Framework\Application();
$router = $app->getRouter();

$router->get('/', fn($r) => (new \App\CalculatorController($r))->index());
$router->post('/calcular', fn($r) => (new \App\CalculatorController($r))->calculate());
$router->get('/api/calcular', fn($r) => (new \App\CalculatorController($r))->calculate());
$router->post('/api/calcular', fn($r) => (new \App\CalculatorController($r))->calculate());

$app->run();
