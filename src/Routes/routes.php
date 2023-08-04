<?php

use Slim\Routing\RouteCollectorProxy;
require __DIR__ . '/../bootstrap.php';
// Define your routes using the $app instance
$app->get('/', function($request, $response) {
    $response->getBody()->write('Hello, world!');
    return $response;
});