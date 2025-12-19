<?php
header("Content-Type: application/json");
include __DIR__ . "/config.php";

$id = $_POST['id'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if(!$id || !$username){
    echo json_encode(["status"=>false,"message"=>"Missing inputs"]);
    exit;
}

// Determine correct username column
$check = $conn->query("SHOW COLUMNS FROM users LIKE 'username'");
$column = $check->num_rows > 0 ? 'username' : 'user_name';

// Update query
$sql = $password ?
    "UPDATE users SET $column='$username', password='".password_hash($password,PASSWORD_DEFAULT)."' WHERE id='$id'" :
    "UPDATE users SET $column='$username' WHERE id='$id'";

if($conn->query($sql)){
    echo json_encode(["status"=>true,"message"=>"User updated successfully"]);
}else{
    echo json_encode(["status"=>false,"message"=>"Database error: ".$conn->error]);
}
?>
