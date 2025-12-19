<?php
include 'db.php';

// Support both form-data and raw JSON
$data = json_decode(file_get_contents('php://input'), true);

$id = $_POST['id'] ?? $data['id'] ?? '';
$user_id = $_POST['user_id'] ?? $data['user_id'] ?? '';

if ($id == '' || $user_id == '') {
    echo json_encode(["status" => "error", "message" => "ID or User ID missing"]);
    exit;
}

// Get existing sketch
$sketch = $conn->query("SELECT * FROM sketches WHERE id=$id")->fetch_assoc();
if (!$sketch) {
    echo json_encode(["status" => "error", "message" => "Sketch not found"]);
    exit;
}

$image_path = $sketch['image_path'];

// Check if a new file is uploaded
if (isset($_FILES['sketch'])) {
    $file = $_FILES['sketch'];
    if (!file_exists('uploads')) mkdir('uploads', 0777, true);
    $image_path = 'uploads/' . time() . '_' . $file['name'];
    move_uploaded_file($file['tmp_name'], $image_path);
    if (file_exists($sketch['image_path'])) unlink($sketch['image_path']);
}

// Update database
$stmt = $conn->prepare("UPDATE sketches SET user_id=?, image_path=? WHERE id=?");
$stmt->bind_param("isi", $user_id, $image_path, $id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Sketch updated",
        "data" => [
            "id" => $id,
            "user_id" => $user_id,
            "image_path" => $image_path,
            "created_at" => $sketch['created_at']
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Update failed"]);
}
?>
