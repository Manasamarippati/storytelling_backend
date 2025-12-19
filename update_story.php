<?php
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$id = $_POST['id'] ?? $data['id'] ?? '';
$user_id = $_POST['user_id'] ?? $data['user_id'] ?? '';
$sketch_id = $_POST['sketch_id'] ?? $data['sketch_id'] ?? '';
$story_text = $_POST['story_text'] ?? $data['story_text'] ?? '';

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

// Update story
$stmt = $conn->prepare("UPDATE stories SET user_id=?, sketch_id=?, story_text=? WHERE id=?");
$stmt->bind_param("iisi", $user_id, $sketch_id, $story_text, $id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Story updated",
        "data" => [
            "id" => $id,
            "user_id" => $user_id,
            "sketch_id" => $sketch_id,
            "story_text" => $story_text,
            "created_at" => $story['created_at']
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Update failed"]);
}
?>
