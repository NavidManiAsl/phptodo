<?php
// need to change according to TODO class
use PDO, PDOException;

require __DIR__ . '/../Database.php';

class TodoRepository
{
  public $db;
  public function __construct()
  {

    $this->db = Database::connect(
      $_ENV['DB_PORT'],
      $_ENV['DB_NAME'],
      $_ENV['DB_USER'],
      $_ENV['DB_PASS']
    );
  }

  public function getAllTasks()
  {
    $stmt = "SELECT * FROM tasks";
    try {
      $query = $this->db->prepare($stmt);
      $query->execute();
      $data = $query->fetchAll(PDO::FETCH_ASSOC);
      return $data;
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }

  public function getTaskById($taskId)
  {
    $query = "SELECT * FROM tasks WHERE id=:id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $taskId);
    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      return $data;
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }

  public function addtask($title, $task, $due)
  {
    $query = "INSERT INTO tasks(title, description, due_date) Values(:title, :task, :due)";
    $stmt = $this->db->prepare($query);
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
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $taskId);

    try {
      $stmt->execute();
      return ["message" => "task: {$taskId}- Has been removed from the database"];
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }

  public function editTask($taskId, $newTitle = null, $newDescription = null)
  {
    $task = $this->getTaskById($taskId);
    if (is_null($task)) {
      return ["message" => "task {$taskId} not found"];
    }
    $query = "UPDATE tasks SET ";
    $params = [];

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
      $stmt = $this->db->prepare($query);
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
    $stmt = $this->db->prepare($query);
    try {
      $stmt->bindParam(':status', $status);
      $stmt->execute();
      return ["message" => "task {$taskId} Staus has been updated"];
    } catch (PDOException $e) {
      return ["message" => $e->getMessage()];
    }
  }
}
