<?php
header('Content-Type: application/json');
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskId = $_POST['task_id'] ?? null;
    $newStatus = $_POST['status'] ?? null;

    if (!$taskId || !$newStatus) {
        echo json_encode(["success" => false, "message" => "Missing task_id or status"]);
        exit;
    }

    $conn = Database::getInstance()->getConnection();
    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $taskId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Task status updated"]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
