<?php
include 'db.php';

$story_id = $_GET['story_id'] ?? null;

if ($story_id) {
    $stmt = $conn->prepare("SELECT * FROM story_audios WHERE story_id = ?");
    $stmt->bind_param("i", $story_id);
} else {
    $stmt = $conn->prepare("SELECT * FROM story_audios");
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(["status" => "success", "data" => $data]);
?>
