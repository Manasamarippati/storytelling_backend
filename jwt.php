<?php
// Include JWT library (install via composer: firebase/php-jwt)
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header("Content-Type: application/json");

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "your_database";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"));

$username = $data->username ?? '';
$password = $data->password ?? '';

// Check user exists
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
    exit;
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password'])) {
    echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
    exit;
}

// JWT secret key
$secretKey = "YOUR_SECRET_KEY";

// Payload
$payload = [
    "iss" => "http://yourdomain.com",
    "aud" => "http://yourdomain.com",
    "iat" => time(),
    "exp" => time() + 3600, // token valid for 1 hour
    "data" => [
        "id" => $user['id'],
        "username" => $user['username']
    ]
];

// Generate JWT
$jwt = JWT::encode($payload, $secretKey, 'HS256');

// Return JSON response
echo json_encode([
    "status" => "success",
    "message" => "Login successful",
    "data" => [
        "id" => $user['id'],
