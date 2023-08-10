<?php

require __DIR__. '/../Database/Repositories/TodoRepository.php';

Class TodoController {

    private $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getAllTasks () {
        $data = $this->todoRepository->getAllTasks();
        return json_encode($data);
    }

    public function getTask ($taskId) {
       $data =  $this->todoRepository->getTaskById($taskId);
       return json_encode($data);
    }

    public function addTask ($title, $task, $due) {
        $data = $this->todoRepository->addTask($title, $task, $due);
        return json_encode($data);
    }

    public function deleteTask($taskId) {
        $data = $this->todoRepository->removeTask($taskId);
        return json_encode($data);
    }

    public function editTask($taskId, $newtitle=null , $newdescription=null) {
        $data = $this->todoRepository->editTask($taskId, $newtitle, $newdescription);
        return json_encode($data);
    }

    public function taskStatusToggle ($taskId) {
        $data = $this->todoRepository->taskStatusChange($taskId);
        return json_encode($data);
    }

} 