<?php
// Enable full error display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include "db.php";
session_start(); // ✅ Start session

// Confirm method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

// Get DB connection
$conn = Database::getInstance()->getConnection();

// Grab inputs from POST
$title = $_POST['title'] ?? '';
$desc = $_POST['description'] ?? '';
$deadline = $_POST['deadline'] ?? '';
$priority = $_POST['priority'] ?? '';
$assigned_to = $_POST['assigned_to'] ?? '';
$created_by = $_SESSION['admin_id'] ?? null; // ✅ Use session ID

// Check for missing data
if (!$title || !$deadline || !$priority || !$assigned_to || !$created_by) {
    echo json_encode(["success" => false, "message" => "Missing required fields or session expired."]);
    exit;
}

// Prepare insert
$stmt = $conn->prepare("INSERT INTO tasks (title, description, deadline, priority, assigned_to, created_by) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("ssssii", $title, $desc, $deadline, $priority, $assigned_to, $created_by);

// Execute insert
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Task created successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Execution failed: " . $stmt->error]);
}
?>
