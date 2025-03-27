<?php
include "db.php";
header('Content-Type: application/json');

$taskId = $_GET['task_id'] ?? null;

if (!$taskId) {
  echo json_encode(["success" => false, "message" => "Task ID missing"]);
  exit;
}

$conn = Database::getInstance()->getConnection();

$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->bind_param("i", $taskId);
$stmt->execute();
$result = $stmt->get_result();

if ($task = $result->fetch_assoc()) {
  echo json_encode(["success" => true, "task" => $task]);
} else {
  echo json_encode(["success" => false, "message" => "Task not found"]);
}
