<?php
include "db.php";

$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$email = $data->email;
$password = password_hash($data->password, PASSWORD_BCRYPT);

$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

if ($conn->query($sql)) {
    echo json_encode([
        "status" => "success",
        "message" => "User registered successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists"
    ]);
}
?>
