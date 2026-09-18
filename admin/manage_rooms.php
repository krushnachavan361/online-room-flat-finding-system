<?php
session_start();
include("../includes/db.php");

// ADMIN CHECK
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin"){
    header("Location: ../user/login.php");
    exit();
}

// DELETE ROOM
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    // DELETE ROOM
    mysqli_query($conn,
    "DELETE FROM rooms WHERE id='$delete_id'");

    // DELETE BOOKINGS
    mysqli_query($conn,
    "DELETE FROM bookings WHERE room_id='$delete_id'");

    // DELETE MESSAGES
    mysqli_query($conn,
    "DELETE FROM messages WHERE room_id='$delete_id'");

    header("Location: manage_rooms.php");
    exit();
}

// FETCH ROOMS
$query = "SELECT rooms.*, users.name

FROM rooms

JOIN users
ON rooms.user_id = users.id

ORDER BY rooms.id DESC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Rooms</title>

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

/* TABLE BOX */

.table-box{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

/* TABLE */

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#111827;
    color:white;
    padding:16px;
    text-align:center;
}

table td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #eee;
}

/* IMAGE */

.room-img{
    width:120px;
    height:80px;
    object-fit:cover;
    border-radius:10px;
}

/* STATUS */

.status{
    padding:8px 14px;
    border-radius:30px;
    color:white;
    font-size:13px;
}

.available{
    background:#00b894;
}

.occupied{
    background:#e74c3c;
}

/* BUTTONS */

.btn{
    padding:10px 16px;
    border-radius:10px;
    color:white;
    text-decoration:none;
    transition:0.3s;
    font-size:14px;
    margin:2px;
    display:inline-block;
}

.view-btn{
    background:#667eea;
}

.view-btn:hover{
    background:#5a67d8;
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
        🏠 Manage Rooms
    </h1>

    <p>
        Admin can manage all room listings
    </p>

</div>

<!-- CONTAINER -->

<div class="container">

    <div class="table-box">

    <?php if(mysqli_num_rows($result) > 0){ ?>

        <table>

            <tr>

                <th>ID</th>

                <th>Image</th>

                <th>Room Title</th>

                <th>Owner</th>

                <th>City</th>

                <th>Area</th>

                <th>Type</th>

                <th>Price</th>

                <th>Status</th>

                <th>Actions</th>

            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>

            <tr>

                <!-- ID -->

                <td>

                    <?php echo $row['id']; ?>

                </td>

                <!-- IMAGE -->

                <td>

                    <img src="../assets/images/<?php echo $row['image']; ?>"
                    class="room-img">

                </td>

                <!-- ROOM TITLE -->

                <td>

                    <?php echo $row['room_title']; ?>

                </td>

                <!-- OWNER -->

                <td>

                    <?php echo $row['name']; ?>

                </td>

                <!-- CITY -->

                <td>

                    <?php echo $row['city']; ?>

                </td>

                <!-- AREA -->

                <td>

                    <?php echo $row['area']; ?>

                </td>

                <!-- ROOM TYPE -->

                <td>

                    <?php echo $row['room_type']; ?>

                </td>

                <!-- PRICE -->

                <td>

                    ₹<?php echo $row['price']; ?>

                </td>

                <!-- STATUS -->

                <td>

                    <span class="status <?php echo $row['status']; ?>">

                        <?php echo ucfirst($row['status']); ?>

                    </span>

                </td>

                <!-- ACTIONS -->

                <td>

                    <!-- VIEW -->

                    <a href="../rooms/room_details.php?id=<?php echo $row['id']; ?>"
                    class="btn view-btn">

                        <i class="fas fa-eye"></i>

                        View

                    </a>

                    <!-- DELETE -->

                    <a href="manage_rooms.php?delete=<?php echo $row['id']; ?>"
                    class="btn delete-btn"

                    onclick="return confirm('Delete this room?')">

                        <i class="fas fa-trash"></i>

                        Delete

                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    <?php } else { ?>

        <!-- EMPTY -->

        <div class="empty">

            <h2>
                ❌ No Rooms Found
            </h2>

        </div>

    <?php } ?>

    </div>

</div>

</body>
</html>