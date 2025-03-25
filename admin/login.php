<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
session_start();
include("../backend/db.php"); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = Database::getInstance()->getConnection();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // If passwords are hashed in DB, use this:
        if (password_verify($password, $user['password'])) {
            // ✅ Store session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; // ← This must exist
        
            echo json_encode([
                "success" => true,
                "user" => [
                    "id" => $user['id'],
                    "username" => $user['username'],
                    "role" => $user['role']
                ]
            ]);
            exit;
        }
        
         else {
            echo json_encode(["success" => false, "message" => "Incorrect password."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
