<?php
$host = "localhost";      // XAMPP default
$user = "root";           // XAMPP default user
$pass = "";               // XAMPP default password (empty)
$db   = "storytelling";   // your database name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
