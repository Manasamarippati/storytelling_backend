<?php
header("Content-Type: application/json");
include __DIR__ . "/config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => false, "message" => "Only POST method allowed"]);
    exit;
}

$story_id = $_POST['story_id'] ?? null;

if (!$story_id || !isset($_FILES['audio_file'])) {
    echo json_encode(["status" => false, "message" => "Missing inputs"]);
    exit;
}

$upload_dir = "uploads/audio/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$file_name = time() . "_" . $_FILES['audio_file']['name'];
$file_path = $upload_dir . $file_name;

if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $file_path)) {

    $sql = "INSERT INTO story_audio (story_id, audio_url) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $story_id, $file_path);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => true,
            "message" => "Audio uploaded successfully",
            "audio_id" => $stmt->insert_id,
            "audio_url" => $file_path
        ]);
    } else {
        echo json_encode(["status" => false, "message" => "Database error"]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Upload failed"]);
}
?>
