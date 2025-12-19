<?php
include 'db.php';

$result = $conn->query("SELECT * FROM sketches ORDER BY created_at DESC");
$sketches = [];

while($row = $result->fetch_assoc()) {
    $sketches[] = [
        "id" => $row['id'],
        "user_id" => $row['user_id'],
        "image_path" => $row['image_path'],
        "created_at" => $row['created_at']
    ];
}

echo json_encode(["status" => "success", "data" => $sketches]);
?>
