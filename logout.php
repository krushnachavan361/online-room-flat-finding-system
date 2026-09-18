<?php
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: user/login.php");
exit();
?>