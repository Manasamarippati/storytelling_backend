<?php
header("Content-Type: application/json");
include __DIR__ . "/config.php";

$id = $_POST['id'] ?? null;
if(!$id){
    echo json_encode(["status"=>false,"message"=>"Missing user ID"]);
    exit;
}

$sql = "DELETE FROM users WHERE id='$id'";
if($conn->query($sql)){
    echo json_encode(["status"=>true,"message"=>"User deleted successfully"]);
}else{
    echo json_encode(["status"=>false,"message"=>"Database error: ".$conn->error]);
}
?>
