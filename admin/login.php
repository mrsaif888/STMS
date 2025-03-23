<?php
header('Content-Type: application/json');
session_start();

include "../backend/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = Database::getInstance()->getConnection();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Incorrect password."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Admin not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
error_log("Submitted password: " . $password);
error_log("Stored hash: " . $admin['password']);

?>
