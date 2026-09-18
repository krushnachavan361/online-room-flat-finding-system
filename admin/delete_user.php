<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

$id = $_GET['id'];

// Prevent deleting admin
$result = mysqli_query($conn, "SELECT role FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if($row['role'] != 'admin'){
    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
}

header("Location: view_users.php");
?>