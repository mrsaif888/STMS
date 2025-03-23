<?php
header('Content-Type: application/json');
include "db.php";
include "factories/UserFactory.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = Database::getInstance()->getConnection();

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (!$username || !$password || !$role) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    // Check for duplicates
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Username already exists."]);
        exit;
    }

    // Create user using Factory
    $user = UserFactory::createUser($username, password_hash($password, PASSWORD_BCRYPT), $role);

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user->username, $user->password, $user->role);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User created successfully via Factory Pattern!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to create user."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
