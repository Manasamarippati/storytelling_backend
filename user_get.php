<?php
header("Content-Type: application/json");

// Include database connection
include __DIR__ . "/config.php";

// Fetch all users
$sql = "SELECT id, username, created_at FROM users";
$result = $conn->query($sql);

$users = [];
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $users[] = $row;
    }
}

echo json_encode([
    "status" => true,
    "message" => "Users fetched successfully",
    "users" => $users
]);
?>
