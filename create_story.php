<?php
include 'db.php';

// Support both form-data and raw JSON
$data = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'] ?? $data['user_id'] ?? '';
$sketch_id = $_POST['sketch_id'] ?? $data['sketch_id'] ?? '';
$story_text = $_POST['story_text'] ?? $data['story_text'] ?? '';

if ($user_id == '' || $sketch_id == '' || $story_text == '') {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO stories (user_id, sketch_id, story_text) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $sketch_id, $story_text);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Story created",
        "data" => [
            "id" => $stmt->insert_id,
            "user_id" => $user_id,
            "sketch_id" => $sketch_id,
            "story_text" => $story_text,
            "created_at" => date("Y-m-d H:i:s")
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Insert failed"]);
}
?>
