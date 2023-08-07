<?php

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require __DIR__. '/../vendor/autoload.php';





$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
