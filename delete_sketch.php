<?php
include 'db.php';

// Support both form-data and raw JSON
$data = json_decode(file_get_contents('php://input'), true);
$id = $_POST['id'] ?? $data['id'] ?? '';

if ($id == '') {
    echo json_encode(["status" => "error", "message" => "ID missing"]);
    exit;
}

// Get existing sketch
$sketch = $conn->query("SELECT * FROM sketches WHERE id=$id")->fetch_assoc();
if (!$sketch) {
    echo json_encode(["status" => "error", "message" => "Sketch not found"]);
    exit;
}

// Delete from database
if ($conn->query("DELETE FROM sketches WHERE id=$id")) {
    if (file_exists($sketch['image_path'])) unlink($sketch['image_path']);
    echo json_encode([
        "status" => "success",
        "message" => "Sketch deleted",
        "data" => [
            "id" => $sketch['id'],
            "user_id" => $sketch['user_id'],
            "image_path" => $sketch['image_path'],
            "created_at" => $sketch['created_at']
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Delete failed"]);
}
?>
