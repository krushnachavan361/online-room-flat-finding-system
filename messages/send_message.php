<?php
session_start();
include("../includes/db.php");

$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];
$message = $_POST['message'];

// Insert message
mysqli_query($conn, "INSERT INTO messages (sender_id, receiver_id, message)
VALUES ('$sender_id', '$receiver_id', '$message')");

// Redirect BACK to same chat
header("Location: chat.php?user_id=$receiver_id");
?>