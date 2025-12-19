<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    
    if (!isset($_FILES['sketch']) || $user_id == '') {
        echo json_encode(["status"=>"error", "message"=>"User ID or file missing"]);
        exit;
    }

    $file = $_FILES['sketch'];
    $image_path = 'uploads/' . time() . '_' . $file['name'];

    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $image_path)) {
        $stmt = $conn->prepare("INSERT INTO sketches (user_id, image_path) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $image_path);
        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Sketch uploaded",
                "data" => [
                    "id" => $stmt->insert_id,
                    "user_id" => $user_id,
                    "image_path" => $image_path,
                    "created_at" => date("Y-m-d H:i:s")
                ]
            ]);
        } else {
            echo json_encode(["status"=>"error", "message"=>"Database insert failed"]);
        }
    } else {
        echo json_encode(["status"=>"error", "message"=>"File upload failed"]);
    }
}
?>
