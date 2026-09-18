<?php
session_start();
include("../includes/db.php");

// ADMIN CHECK
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin"){
    header("Location: ../user/login.php");
    exit();
}

// DELETE USER
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM users WHERE id='$delete_id'");

    header("Location: manage_users.php");
    exit();
}

// BLOCK USER
if(isset($_GET['block'])){

    $block_id = $_GET['block'];

    mysqli_query($conn,
    "UPDATE users
    SET status='blocked'
    WHERE id='$block_id'");

    header("Location: manage_users.php");
    exit();
}

// UNBLOCK USER
if(isset($_GET['unblock'])){

    $unblock_id = $_GET['unblock'];

    mysqli_query($conn,
    "UPDATE users
    SET status='active'
    WHERE id='$unblock_id'");

    header("Location: manage_users.php");
    exit();
}

// FETCH USERS
$query = "SELECT * FROM users
ORDER BY id DESC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Users</title>

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- ICON -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f4f6f9;
}

/* HEADER */

.header{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    padding:30px;
    text-align:center;
}

.header h1{
    font-size:36px;
    margin-bottom:10px;
}

/* CONTAINER */

.container{
    width:95%;
    margin:40px auto;
}

/* TABLE */

.table-box{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#111827;
    color:white;
    padding:16px;
}

table td{
    padding:15px;
    border-bottom:1px solid #eee;
    text-align:center;
}

/* ROLE */

.role{
    padding:7px 14px;
    border-radius:30px;
    color:white;
    font-size:13px;
}

.user{
    background:#3498db;
}

.owner{
    background:#00b894;
}

.admin{
    background:#9b59b6;
}

/* STATUS */

.status{
    padding:7px 14px;
    border-radius:30px;
    color:white;
    font-size:13px;
}

.active{
    background:#27ae60;
}

.blocked{
    background:#e74c3c;
}

/* BUTTONS */

.btn{
    padding:10px 15px;
    border-radius:10px;
    text-decoration:none;
    color:white;
    font-size:14px;
    margin:2px;
    display:inline-block;
    transition:0.3s;
}

.block-btn{
    background:#f39c12;
}

.block-btn:hover{
    background:#d68910;
}

.unblock-btn{
    background:#00b894;
}

.unblock-btn:hover{
    background:#00997a;
}

.delete-btn{
    background:#e74c3c;
}

.delete-btn:hover{
    background:#c0392b;
}

/* EMPTY */

.empty{
    padding:50px;
    text-align:center;
    color:#555;
}

</style>
</head>

<body>

<!-- HEADER -->

<div class="header">

    <h1>
        👥 Manage Users
    </h1>

    <p>
        Admin can manage all users and owners
    </p>

</div>

<!-- CONTAINER -->

<div class="container">

<div class="table-box">

<?php if(mysqli_num_rows($result) > 0){ ?>

<table>

<tr>

    <th>ID</th>

    <th>Name</th>

    <th>Email</th>

    <th>Phone</th>

    <th>Role</th>

    <th>Status</th>

    <th>Actions</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <!-- ID -->

    <td>

        <?php echo $row['id']; ?>

    </td>

    <!-- NAME -->

    <td>

        <?php echo $row['name']; ?>

    </td>

    <!-- EMAIL -->

    <td>

        <?php echo $row['email']; ?>

    </td>

    <!-- PHONE -->

    <td>

        <?php echo $row['phone']; ?>

    </td>

    <!-- ROLE -->

    <td>

        <span class="role <?php echo $row['role']; ?>">

            <?php echo ucfirst($row['role']); ?>

        </span>

    </td>

    <!-- STATUS -->

    <td>

        <span class="status <?php echo $row['status']; ?>">

            <?php echo ucfirst($row['status']); ?>

        </span>

    </td>

    <!-- ACTIONS -->

    <td>

        <?php if($row['status']=="active"){ ?>

        <!-- BLOCK -->

        <a href="manage_users.php?block=<?php echo $row['id']; ?>"
        class="btn block-btn">

            <i class="fas fa-ban"></i>

            Block

        </a>

        <?php } else { ?>

        <!-- UNBLOCK -->

        <a href="manage_users.php?unblock=<?php echo $row['id']; ?>"
        class="btn unblock-btn">

            <i class="fas fa-check"></i>

            Unblock

        </a>

        <?php } ?>

        <!-- DELETE -->

        <a href="manage_users.php?delete=<?php echo $row['id']; ?>"
        class="btn delete-btn"

        onclick="return confirm('Delete this user?')">

            <i class="fas fa-trash"></i>

            Delete

        </a>

    </td>

</tr>

<?php } ?>

</table>

<?php } else { ?>

<div class="empty">

    <h2>
        ❌ No Users Found
    </h2>

</div>

<?php } ?>

</div>

</div>

</body>
</html>