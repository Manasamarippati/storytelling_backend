<?php
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $_POST['id'] ?? $data['id'] ?? '';

if ($id == '') {
    echo json_encode(["status" => "error", "message" => "Story ID missing"]);
    exit;
}

// Check if story exists
$story = $conn->query("SELECT * FROM stories WHERE id=$id")->fetch_assoc();
if (!$story) {
    echo json_encode(["status" => "error", "message" => "Story not found"]);
    exit;
}

// Delete story
if ($conn->query("DELETE FROM stories WHERE id=$id")) {
    echo json_encode(["status" => "success", "message" => "Story deleted"]);
} else {
    echo json_encode(["status" => "error", "message" => "Delete failed"]);
}
?>
