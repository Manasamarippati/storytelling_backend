<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['story_id']) || !isset($_FILES['audio_file'])) {
        echo json_encode(["status" => "error", "message" => "story_id and audio_file required"]);
        exit;
    }

    $story_id = $_POST['story_id'];

    $uploadDir = "uploads/audio/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . "_" . $_FILES['audio_file']['name'];
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $filePath)) {

        $stmt = $conn->prepare("INSERT INTO story_audios (story_id, audio_file) VALUES (?, ?)");
        $stmt->bind_param("is", $story_id, $filePath);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Audio added"]);
        } else {
            echo json_encode(["status" => "error", "message" => "DB insert failed"]);
        }

    } else {
        echo json_encode(["status" => "error", "message" => "File upload failed"]);
    }
}
?>
