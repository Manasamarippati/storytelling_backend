<?php
header("Content-Type: application/json");

// Include database connection
include "config.php";

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

// Validate required fields
if (!isset($_POST['user_id']) || !isset($_POST['sketch_id']) || !isset($_POST['story_text'])) {
    echo json_encode(["status" => "error", "message" => "Missing required inputs"]);
    exit;
}

$user_id = intval($_POST['user_id']);
$sketch_id = intval($_POST['sketch_id']);
$story_text = $conn->real_escape_string($_POST['story_text']);

// Insert into database
$sql = "INSERT INTO stories (user_id, sketch_id, story_text) 
        VALUES ('$user_id', '$sketch_id', '$story_text')";

if ($conn->query($sql)) {
    echo json_encode([
        "status" => "success",
        "message" => "Story saved successfully",
        "data" => [
            "id" => $conn->insert_id,
            "user_id" => $user_id,
            "sketch_id" => $sketch_id,
            "story_text" => $story_text
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
}

$conn->close();
?>
