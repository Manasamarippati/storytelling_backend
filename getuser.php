<?php
header("Content-Type: application/json");
include __DIR__ . "/config.php";

// Optional: fetch single user by ?id=1
$id = $_GET['id'] ?? null;

// Determine correct username column
$check = $conn->query("SHOW COLUMNS FROM users LIKE 'username'");
$column = $check->num_rows > 0 ? 'username' : 'user_name';

if ($id) {
    $sql = "SELECT id, $column AS username, created_at FROM users WHERE id='$id'";
    $result = $conn->query($sql);
    if($result && $result->num_rows > 0){
        $user = $result->fetch_assoc();
        echo json_encode(["status"=>true,"user"=>$user]);
    } else {
        echo json_encode(["status"=>false,"message"=>"User not found"]);
    }
} else {
    $sql = "SELECT id, $column AS username, created_at FROM users";
    $result = $conn->query($sql);
    $users = [];
    while($row = $result->fetch_assoc()){
        $users[] = $row;
    }
    echo json_encode(["status"=>true,"users"=>$users]);
}
?>
