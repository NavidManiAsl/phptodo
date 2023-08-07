<?php

use Slim\Routing\RouteCollectorProxy;
require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../Controllers/TodoController.php';



$app->get('/', function($request, $response) {
    $response->getBody()->write('Hello, world!');
    return $response;
});
$app->group('/tasks', function (RouteCollectorProxy $group) {

    $todoController = new TodoController(new TodoRepository(new Database(
        $_ENV['POSTGRES_PORT'],
        $_ENV['POSTGRES_DB'],
        $_ENV['POSTGRES_USER'],
        $_ENV['POSTGRES_PASSWORD']
    )));

    $group->get('', [$todoController, 'getAllTasks']);
    $group->get('/{id}', [$todoController, 'getTask']);
    $group->post('', [$todoController, 'addTask']);
    $group->delete('/{id}', [$todoController, 'deleteTask']);
    $group->put('/{id}', [$todoController, 'editTask']);
    $group->put('/{id}/toggle', [$todoController, 'taskStatusToggle']);
});

