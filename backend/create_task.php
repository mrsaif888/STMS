<?php
session_start();
header('Content-Type: application/json');
include "db.php";

// Enable error reporting for development
ini_set('display_errors', 1);
error_reporting(E_ALL);
error_log("Session: " . print_r($_SESSION, true));
// Check method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Session not set. Please log in."]);
    exit;
}

// Auth check
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'team-lead'])) {
    error_log("SESSION DEBUG: " . print_r($_SESSION, true)); // Add this line
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}


$conn = Database::getInstance()->getConnection();

// Collect inputs
$title = $_POST['title'] ?? '';
$desc = $_POST['description'] ?? '';
$deadline = $_POST['deadline'] ?? '';
$priority = $_POST['priority'] ?? '';
$assigned_to = $_POST['assigned_to'] ?? null;
$created_by = $_SESSION['user_id'];
$status = 'todo';

// Validate
if (!$title || !$deadline || !$priority || !$assigned_to) {
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
    exit;
}

// Insert task
$stmt = $conn->prepare("INSERT INTO tasks (title, description, deadline, priority, assigned_to, created_by, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssis", $title, $desc, $deadline, $priority, $assigned_to, $created_by, $status);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Task created successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to create task: " . $stmt->error]);
}
?>
