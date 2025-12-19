<?php
header("Content-Type: application/json");
include __DIR__ . "/config.php";

// Allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => false, "message" => "Only POST allowed"]);
    exit;
}

// Check required values
if (!isset($_POST['story_id']) || !isset($_FILES['audio_file'])) {
    echo json_encode(["status" => false, "message" => "Missing inputs"]);
    exit;
}

$story_id = $_POST['story_id'];

// Upload directory
$upload_dir = "uploads/audio/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Generate file name
$filename = time() . "_" . basename($_FILES['audio_file']['name']);
$target_file = $upload_dir . $filename;

// Move uploaded file
if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $target_file)) {

    // Insert into DB
    $sql = "INSERT INTO story_audios (story_id, audio_file) VALUES ('$story_id', '$target_file')";
    if ($conn->query($sql)) {
        echo json_encode([
            "status" => true,
            "message" => "Audio uploaded successfully",
            "audio_id" => $conn->insert_id,
            "file_path" => $target_file
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "DB Error: " . $conn->error
        ]);
    }

} else {
    echo json_encode([
        "status" => false,
        "message" => "File upload failed"
    ]);
}
?>
