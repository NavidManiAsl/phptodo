<?php

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require __DIR__. '/../vendor/autoload.php';





$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$app = AppFactory::create();
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response
    ->withHeader('Access-Control-Allow-Origin', 'http://localhost:5173')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
    ->withHeader('Access-Control-Allow-Origin', 'http://localhost:5173')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
$app->addBodyParsingMiddleware();
