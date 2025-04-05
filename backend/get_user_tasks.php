<?php
session_start();
header('Content-Type: application/json');

include "db.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$conn = Database::getInstance()->getConnection();
$stmt = $conn->prepare("SELECT t.*, u.username AS assigned_username, u.role AS assigned_role 
                        FROM tasks t 
                        JOIN users u ON t.assigned_to = u.id 
                        WHERE t.assigned_to = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$tasks = [];

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode(["success" => true, "tasks" => $tasks]);
