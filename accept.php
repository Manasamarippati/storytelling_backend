<?php
header("Content-Type: application/json");
include "db.php";   // include DB connection

// Check if file is sent
if (!isset($_FILES['sketch'])) {
    echo json_encode([
        "status" => "error",
        "message" => "No image uploaded"
    ]);
    exit;
}

// Check user_id
$user_id = $_POST['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "status" => "error",
        "message" => "User ID missing"
    ]);
    exit;
}

// Upload folder
$uploadDir = "uploads/sketches/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Create file name
$filename = time() . "_" . basename($_FILES["sketch"]["name"]);
$targetFile = $uploadDir . $filename;

// Upload image
if (!move_uploaded_file($_FILES["sketch"]["tmp_name"], $targetFile)) {
    echo json_encode([
        "status" => "error",
        "message" => "File upload failed"
    ]);
    exit;
}

// Save to database
$sql = "INSERT INTO sketches (user_id, image_path) VALUES ('$user_id', '$targetFile')";

if ($conn->query($sql)) {
    echo json_encode([
        "status" => "success",
        "message" => "Sketch uploaded successfully",
        "data" => [
            "image_path" => $targetFile
        ]
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database error"
    ]);
}
?>
