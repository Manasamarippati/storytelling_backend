<?php
header("Content-Type: application/json");

// Include DB connection
include __DIR__ . "/config.php";

// Accept only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => false,
        "message" => "Only POST allowed"
    ]);
    exit;
}

// Required fields check
if (!isset($_POST['user_id']) || !isset($_POST['sketch_id']) || !isset($_POST['story_text'])) {
    echo json_encode([
        "status" => false,
        "message" => "Missing inputs"
    ]);
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
        "status" => true,
        "message" => "Story saved successfully",
        "story_id" => $conn->insert_id
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Database error: " . $conn->error
    ]);
}
?>
