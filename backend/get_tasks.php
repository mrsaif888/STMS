<?php
header('Content-Type: application/json');
include "db.php";
session_start();

$conn = Database::getInstance()->getConnection();

$query = "
    SELECT 
        t.id,
        t.title,
        t.description,
        t.deadline,
        t.priority,
        t.status,
        t.assigned_to,
        u.username AS assigned_username,
        u.role AS assigned_role
    FROM tasks t
    LEFT JOIN users u ON t.assigned_to = u.id
";

$result = $conn->query($query);

$tasks = [];

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode(["tasks" => $tasks]);
?>
