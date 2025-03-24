<?php
header('Content-Type: application/json');
include "db.php";

$conn = Database::getInstance()->getConnection();

$result = $conn->query("SELECT id, username, role FROM users WHERE role IN ('user', 'team-lead')");

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode(["users" => $users]);
?>
