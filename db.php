<?php
$servername = "localhost";    // Usually localhost
$username = "root";           // Your MySQL username
$password = "";               // Your MySQL password
$database = "storytelling";   // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}
?>
