<?php
header('Content-Type: application/json');
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$conn = Database::getInstance()->getConnection();
$user_id = $_SESSION['user_id'];

$query = "SELECT t.id, t.title, t.description, t.deadline, t.priority, t.status 
          FROM tasks t 
          WHERE t.assigned_to = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$tasks = [];

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode(["tasks" => $tasks]);
?>
