<?php
header('Content-Type: application/json');
include "db.php";

$conn = Database::getInstance()->getConnection();

// Fetch users who are not admin or team-lead (can be promoted)
$sql = "SELECT id, username FROM users WHERE role = 'user'";
$result = $conn->query($sql);

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode(["users" => $users]);
?>
