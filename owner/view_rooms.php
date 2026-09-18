<?php
session_start();
include("../includes/db.php");

// LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// DELETE ROOM
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    // DELETE ROOM
    mysqli_query($conn,
    "DELETE FROM rooms
    WHERE id='$delete_id'
    AND user_id='$user_id'");

    header("Location: view_rooms.php");
    exit();
}

// FETCH OWNER ROOMS
$query = "SELECT * FROM rooms

WHERE user_id='$user_id'

ORDER BY id DESC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Rooms</title>

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
    width:90%;
    margin:40px auto;
}

/* TOP ACTION */

.top-action{
    text-align:right;
    margin-bottom:25px;
}

/* BUTTON */

.add-btn{
    background:#00b894;
    color:white;
    padding:14px 22px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.add-btn:hover{
    background:#00997a;
}

/* ROOM GRID */

.room-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:25px;
}

/* CARD */

.room-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}

.room-card:hover{
    transform:translateY(-5px);
}

/* IMAGE */

.room-image{
    width:100%;
    height:240px;
}

.room-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* CONTENT */

.room-content{
    padding:20px;
}

/* TITLE */

.room-title{
    font-size:26px;
    font-weight:bold;
    color:#111827;
    margin-bottom:10px;
}

/* PRICE */

.price{
    color:#00b894;
    font-size:24px;
    font-weight:bold;
    margin-bottom:15px;
}

/* INFO */

.info{
    margin-bottom:10px;
    color:#555;
}

/* STATUS */

.status{
    display:inline-block;
    padding:8px 15px;
    border-radius:30px;
    color:white;
    font-size:13px;
    margin-top:10px;
}

.available{
    background:#00b894;
}

.occupied{
    background:#e74c3c;
}

/* BUTTONS */

.btns{
    margin-top:20px;
    display:flex;
    gap:12px;
    flex-wrap:wrap;
}

.btn{
    flex:1;
    text-align:center;
    padding:12px;
    border-radius:12px;
    color:white;
    text-decoration:none;
    transition:0.3s;
    font-weight:600;
}

.view-btn{
    background:#667eea;
}

.view-btn:hover{
    background:#5a67d8;
}

.edit-btn{
    background:#f39c12;
}

.edit-btn:hover{
    background:#d68910;
}

.delete-btn{
    background:#e74c3c;
}

.delete-btn:hover{
    background:#c0392b;
}

/* EMPTY */

.empty{
    background:white;
    padding:50px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

.empty h2{
    color:#555;
}

/* RESPONSIVE */

@media(max-width:768px){

    .btns{
        flex-direction:column;
    }
}

</style>
</head>

<body>

<!-- HEADER -->

<div class="header">

    <h1>
        🏠 My Rooms
    </h1>

    <p>
        Manage all your room listings
    </p>

</div>

<!-- CONTAINER -->

<div class="container">

    <!-- ADD ROOM -->

    <div class="top-action">

        <a href="../rooms/add_room.php"
        class="add-btn">

            <i class="fas fa-plus-circle"></i>

            Add New Room

        </a>

    </div>

<?php if(mysqli_num_rows($result) > 0){ ?>

    <!-- ROOM GRID -->

    <div class="room-grid">

    <?php while($row = mysqli_fetch_assoc($result)){ ?>

        <!-- ROOM CARD -->

        <div class="room-card">

            <!-- IMAGE -->

            <div class="room-image">

                <img src="../assets/images/<?php echo $row['image']; ?>">

            </div>

            <!-- CONTENT -->

            <div class="room-content">

                <!-- TITLE -->

                <div class="room-title">

                    <?php echo $row['room_title']; ?>

                </div>

                <!-- PRICE -->

                <div class="price">

                    ₹<?php echo $row['price']; ?>/month

                </div>

                <!-- INFO -->

                <div class="info">

                    📍 <?php echo $row['city']; ?>

                </div>

                <div class="info">

                    🏠 <?php echo $row['room_type']; ?>

                </div>

                <div class="info">

                    📌 <?php echo $row['area']; ?>

                </div>

                <!-- STATUS -->

                <span class="status <?php echo $row['status']; ?>">

                    <?php echo ucfirst($row['status']); ?>

                </span>

                <!-- BUTTONS -->

                <div class="btns">

                    <!-- VIEW -->

                    <a href="../rooms/room_details.php?id=<?php echo $row['id']; ?>"
                    class="btn view-btn">

                        <i class="fas fa-eye"></i>

                        View

                    </a>

                    <!-- EDIT -->

                    <a href="../rooms/edit_room.php?id=<?php echo $row['id']; ?>"
                    class="btn edit-btn">

                        <i class="fas fa-edit"></i>

                        Edit

                    </a>

                    <!-- DELETE -->

                    <a href="view_rooms.php?delete=<?php echo $row['id']; ?>"
                    class="btn delete-btn"

                    onclick="return confirm('Delete this room?')">

                        <i class="fas fa-trash"></i>

                        Delete

                    </a>

                </div>

            </div>

        </div>

    <?php } ?>

    </div>

<?php } else { ?>

    <!-- EMPTY -->

    <div class="empty">

        <h2>
            ❌ No Rooms Added Yet
        </h2>

    </div>

<?php } ?>

</div>

</body>
</html>