<?php
include 'db.php';

$result = $conn->query("SELECT * FROM stories ORDER BY created_at DESC");
$stories = [];

while($row = $result->fetch_assoc()) {
    $stories[] = $row;
}

echo json_encode(["status" => "success", "data" => $stories]);
?>
