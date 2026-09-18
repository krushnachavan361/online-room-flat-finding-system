<?php
// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check admin login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../user/login.php");
    exit();
}
?>