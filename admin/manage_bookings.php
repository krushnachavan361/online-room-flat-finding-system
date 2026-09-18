<?php
session_start();
include("../includes/db.php");

// ADMIN CHECK
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin"){
    header("Location: ../user/login.php");
    exit();
}

// DELETE BOOKING
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM bookings
    WHERE id='$delete_id'");

    header("Location: manage_bookings.php");
    exit();
}

// FETCH BOOKINGS
$query = "SELECT bookings.*,

u.name AS user_name,

o.name AS owner_name,

rooms.room_title,
rooms.city,
rooms.price

FROM bookings

JOIN users u
ON bookings.user_id = u.id

JOIN users o
ON bookings.owner_id = o.id

JOIN rooms
ON bookings.room_id = rooms.id

ORDER BY bookings.id DESC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Bookings</title>

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
    padding:15px;
}

table td{
    padding:14px;
    border-bottom:1px solid #eee;
    text-align:center;
}

/* STATUS */

.status{
    padding:7px 14px;
    border-radius:30px;
    color:white;
    font-size:13px;
}

.pending{
    background:orange;
}

.accepted{
    background:green;
}

.rejected{
    background:red;
}

/* BUTTON */

.btn{
    padding:10px 15px;
    border-radius:10px;
    color:white;
    text-decoration:none;
    transition:0.3s;
    display:inline-block;
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
        📅 Manage Bookings
    </h1>

    <p>
        Admin can monitor all room bookings
    </p>

</div>

<!-- CONTAINER -->

<div class="container">

<div class="table-box">

<?php if(mysqli_num_rows($result) > 0){ ?>

<table>

<tr>

    <th>ID</th>

    <th>User</th>

    <th>Owner</th>

    <th>Room</th>

    <th>City</th>

    <th>Price</th>

    <th>Move Date</th>

    <th>Members</th>

    <th>Status</th>

    <th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <!-- ID -->

    <td>

        <?php echo $row['id']; ?>

    </td>

    <!-- USER -->

    <td>

        <?php echo $row['user_name']; ?>

    </td>

    <!-- OWNER -->

    <td>

        <?php echo $row['owner_name']; ?>

    </td>

    <!-- ROOM -->

    <td>

        <?php echo $row['room_title']; ?>

    </td>

    <!-- CITY -->

    <td>

        <?php echo $row['city']; ?>

    </td>

    <!-- PRICE -->

    <td>

        ₹<?php echo $row['price']; ?>

    </td>

    <!-- MOVE DATE -->

    <td>

        <?php echo $row['move_date']; ?>

    </td>

    <!-- MEMBERS -->

    <td>

        <?php echo $row['members']; ?>

    </td>

    <!-- STATUS -->

    <td>

        <span class="status <?php echo $row['status']; ?>">

            <?php echo ucfirst($row['status']); ?>

        </span>

    </td>

    <!-- ACTION -->

    <td>

        <a href="manage_bookings.php?delete=<?php echo $row['id']; ?>"
        class="btn delete-btn"

        onclick="return confirm('Delete this booking?')">

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
        ❌ No Bookings Found
    </h2>

</div>

<?php } ?>

</div>

</div>

</body>
</html>