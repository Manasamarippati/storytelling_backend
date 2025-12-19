<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['id'])) {
        echo json_encode(["status" => "error", "message" => "id required"]);
        exit;
    }

    $id = $_POST['id'];
    $story_id = $_POST['story_id'] ?? null;
    $newAudio = null;

    // new file?
    if (isset($_FILES['audio_file'])) {
        $uploadDir = "uploads/audio/";
        $fileName = time() . "_" . $_FILES['audio_file']['name'];
        $newAudio = $uploadDir . $fileName;
        move_uploaded_file($_FILES['audio_file']['tmp_name'], $newAudio);
    }

    if ($newAudio) {
        $stmt = $conn->prepare("UPDATE story_audios SET story_id = ?, audio_file = ? WHERE id = ?");
        $stmt->bind_param("isi", $story_id, $newAudio, $id);
    } else {
        $stmt = $conn->prepare("UPDATE story_audios SET story_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $story_id, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Updated"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed"]);
    }
}
?>
