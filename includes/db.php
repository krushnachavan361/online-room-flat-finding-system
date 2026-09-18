<?php
// Database connection settings
$host = "localhost";
$user = "root";
$password = "";
$database = "room_rental";

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: success message (for testing only)
// echo "Database Connected Successfully!";
?>