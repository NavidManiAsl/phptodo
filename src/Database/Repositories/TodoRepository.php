<?php

use PDO, PDOException;

require __DIR__ . '/../../Models/Todo.php';
require __DIR__ . '/../Database.php';

class TodoRepository
{
  private $db;
  public function __construct(Database $db)
  {

    $this->db = $db;
  }

  public function getAllTasks()
  {
    $query = "SELECT * FROM tasks";
    try {
      $pdo = $this->db->getConnection();
      $stmt = $pdo->prepare($query);
      $stmt->execute();
      $dataRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $todos = [];
      if (!empty($dataRows)) {
        foreach ($dataRows as $row) {
          $todo = new Todo(
            $row['id'],
            $row['title'],
            $row['description'],
            $row['due_date'],
            $row['done'],
          );
          array_push($todos, $todo);
        }
      }
      return $todos;
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }

  public function getTaskById($taskId)
  {
    $query = "SELECT * FROM tasks WHERE id=:id";
    $pdo = $this->db->getConnection();
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $taskId);
    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!empty($data)) {
        $todo = new Todo(
          $data['id'],
          $data['title'],
          $data['description'],
          $data['due_date'],
          $data['done']
        );
        return $todo;
      }
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }

  public function addTask($title, $task, $due)
  {
    $query = "INSERT INTO tasks(title, description, due_date, done) Values(:title, :task, :due, false)";
    $pdo = $this->db->getConnection();
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(':task', $task);
    $stmt->bindParam(':due', $due);
    try {
      $stmt->execute();
      return ["message" => "{$title} Added to database successfully"];
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }

  public function removeTask($taskId)
  {
    $query = "DELETE FROM tasks WHERE id=:id";
    $pdo = $this->db->getConnection();
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $taskId);

    try {
      $stmt->execute();
      return ["message" => "task: {$taskId}- Has been removed from the database"];
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }

  public function editTask($taskId, $newTitle, $newDescription)
  {
    $task = $this->getTaskById($taskId);
    if (is_null($task)) {
      return ["message" => "task {$taskId} not found"];
    }
    $query = "UPDATE tasks SET ";
    $params = [];
    $pdo = $this->db->getConnection();

    if ($newTitle) {
      $query .= "title =:title";
      $params[':title'] = $newTitle;
    }

    if ($newDescription) {
      $query .= "description =:description";
      $params[':description'] = $newDescription;
    }
    if (sizeof($params) === 0) {
      return ["message" => "Nothing has been changed"];
    }
    try {
      $stmt = $pdo->prepare($query);
      foreach ($params as $param => $value) {
        $stmt->bindParam($param, $value);
      }
      $stmt->execute();
      return ["message" => "task: {$taskId} Has been updated successfully"];
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }

  public function taskStatusChange($taskId)
  {
    $task = $this->getTaskById($taskId);
    if (is_null($task)) {
      return ["message" => "task {$taskId} Not found"];
    }
    $status = !$task['done'];
    $query = "UPDATE tasks set done=:status";
    $pdo = $this->db->getConnection();
    $stmt = $pdo->prepare($query);
    try {
      $stmt->bindParam(':status', $status);
      $stmt->execute();
      return ["message" => "task {$taskId} Staus has been updated"];
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }
}
