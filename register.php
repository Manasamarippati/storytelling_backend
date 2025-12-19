<?php
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$id = $_POST['id'] ?? $data['id'] ?? null;
$username = $_POST['username'] ?? $data['username'] ?? '';
$email = $_POST['email'] ?? $data['email'] ?? '';
$phone = $_POST['phone'] ?? $data['phone'] ?? '';
$password = $_POST['password'] ?? $data['password'] ?? '';
$usertype = $_POST['usertype'] ?? $data['usertype'] ?? '';

if ($username == '' || $email == '' || $phone == '' || $password == '' || $usertype == '') {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

if ($id) {
    $stmt = $conn->prepare("INSERT INTO users (id, username, email, phone, password, usertype) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id, $username, $email, $phone, $password, $usertype);
} else {
    $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password, usertype) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $phone, $password, $usertype);
}

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "User created",
        "data" => [
            "id" => $id ?? $stmt->insert_id,
            "username" => $username,
            "email" => $email,
            "phone" => $phone,
            "password" => $password,
            "usertype" => $usertype
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Insert failed"]);
}
?>
