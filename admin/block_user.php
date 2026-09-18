<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

$id = $_GET['id'];

mysqli_query($conn, "UPDATE users SET status='blocked' WHERE id='$id'");

header("Location: view_users.php");
?>