<?php
header('Content-Type: application/json');
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = Database::getInstance()->getConnection();

    $userId = $_POST['user_id'] ?? null;

    if (!$userId) {
        echo json_encode(["success" => false, "message" => "User ID missing."]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET role = 'team-lead' WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Team Lead assigned successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to assign Team Lead."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
