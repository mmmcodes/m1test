<?php
require __DIR__ . '/vendor/autoload.php';

$container = new \App\Container\Container();
$request = new \App\Request();
$router = new \App\Services\RouterService($request);
$router->processRequest($container);