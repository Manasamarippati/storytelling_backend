<?php
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$email = $_POST['email'] ?? $data['email'] ?? '';
$password = $_POST['password'] ?? $data['password'] ?? '';

header("Content-Type: application/json");

if ($email === '' || $password === '') {
    echo json_encode([
        "status" => "error",
        "message" => "Email and password are required"
    ]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode([
        "status" => "error",
        "message" => "User not found"
    ]);
    exit;
}

// ⚠️ Plain text password comparison
if ($password === $user['password']) {
    echo json_encode([
        "status" => "success",
        "message" => "Login successful"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid credentials"
    ]);
}
?>
