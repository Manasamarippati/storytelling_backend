<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? '';

if ($id == '') {
    echo json_encode(["status" => "error", "message" => "id required"]);
    exit;
}

$sql = "DELETE FROM sketches WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Record deleted"]);
} else {
    echo json_encode(["status" => "error", "message" => "Delete failed"]);
}
?>
