<?php
include "../backend/db.php";

$conn = Database::getInstance()->getConnection();

$username = "admin";
$password = "admin123"; // plain text
$role = "admin";

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Check if user already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "❗ Admin user already exists.";
    exit;
}

$stmt->close();

// Insert admin
$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "✅ Admin user created with hashed password!";
} else {
    echo "❌ Failed: " . $stmt->error;
}
?>
