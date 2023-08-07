<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require __DIR__. '/../Database/Repositories/TodoRepository.php';

Class TodoController {

    private $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getAllTasks(Request $request, Response $response) {
        $datarows = $this->todoRepository->getAllTasks();
        $todos=[];
        foreach($datarows as $todo) {
            $todo =[
                "title" => $todo->getTitle(),
                "description" => $todo->getDescription(),
                "due_date" => $todo->getDue(),
                "status" => $todo->getDone()
            ];
            array_push($todos, $todo);
        }
        $response->getBody()->write(json_encode($todos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getTask (Request $request, Response $response, $params) {
       $taskId = $params['id'];
        $data = $this->todoRepository->getTaskById($taskId);
        $todo = [
            "title" => $data->getTitle(),
            "description" => $data->getDescription(),
            "due_date" => $data->getDue(),
            "status" => $data->getDone()
        ];
        $response->getBody()->write(json_encode($todo));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function addTask (Request $request,Response $response) {
        $params = $request->getParsedBody();
        $data = $this->todoRepository->addTask($params['title'], $params['description'], $params["due_date"]);
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteTask(Request $request, Response $response, $params) {
       $taskId = $params['id'];
       $data = $this->todoRepository->removeTask($taskId);
       $response->getBody()->write(json_encode($data));
       return $response->withHeader('Content-Type', 'application/json');
    }
    // TODO : make due_date editable
    public function changeTask(Request $request, Response $response, $params) {
        $taskId = $params['id'];
        $bodyparams = $request->getParsedBody();
        $data = $this->todoRepository->editTask($taskId, $bodyparams['title']??null, $bodyparams['description']??null);
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-type', 'application/json');
    }

    public function taskStatusToggle (Request $request, Response $response, $params) {
        $taskId = $params['id'];
        $data = $this->todoRepository->taskStatusChange($taskId);
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-type', 'application/json');
    }

} 