<?php
header('Content-Type: application/json');
session_start();

include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = Database::getInstance()->getConnection();

    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $priority = $_POST['priority'];
    $assigned_to = $_POST['assigned_to'];

    $stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, deadline=?, priority=?, assigned_to=? WHERE id=?");
    $stmt->bind_param("ssssii", $title, $description, $deadline, $priority, $assigned_to, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $stmt->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
