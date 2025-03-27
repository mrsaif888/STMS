<?php
session_start();
include "db.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid method"]);
    exit;
}

$taskId = $_POST["task_id"] ?? null;

if (!$taskId) {
    echo json_encode(["success" => false, "message" => "Missing task ID"]);
    exit;
}

$conn = Database::getInstance()->getConnection();
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->bind_param("i", $taskId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Delete failed"]);
}
