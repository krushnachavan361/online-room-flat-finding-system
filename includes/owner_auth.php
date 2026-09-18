<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner') {
    header("Location: ../user/login.php");
    exit();
}
?>