<?php
session_start();
include("../includes/db.php");

// CHECK ROOM ID
if(!isset($_GET['id'])){
    header("Location:view_rooms.php");
    exit();
}

$room_id = $_GET['id'];

// FETCH ROOM DETAILS
$query = "SELECT rooms.*, users.name, users.phone, users.email
FROM rooms
JOIN users ON rooms.user_id = users.id
WHERE rooms.id='$room_id'";

$result = mysqli_query($conn,$query);

$room = mysqli_fetch_assoc($result);

if(!$room){
    die("Room Not Found");
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $room['room_title']; ?></title>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- FONT AWESOME -->
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

/* MAIN */

.container{
    width:90%;
    margin:30px auto;
    display:flex;
    gap:25px;
}

/* LEFT */

.left{
    width:70%;
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

/* IMAGE */

.room-image img{
    width:100%;
    height:450px;
    object-fit:cover;
}

/* CONTENT */

.content{
    padding:25px;
}

/* TITLE */

.room-title{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.room-title h1{
    font-size:32px;
    color:#111827;
}

.price{
    font-size:28px;
    color:#00b894;
    font-weight:bold;
}

/* INFO */

.info-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
    margin-top:20px;
}

.info-box{
    background:#f4f6f9;
    padding:18px;
    border-radius:15px;
}

.info-box i{
    color:#00b894;
    margin-right:8px;
}

/* DESCRIPTION */

.description{
    margin-top:30px;
}

.description h2{
    margin-bottom:15px;
}

.description p{
    line-height:1.8;
    color:#555;
}

/* AMENITIES */

.amenities{
    margin-top:30px;
}

.amenities h2{
    margin-bottom:15px;
}

.amenities-list{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
}

.amenity{
    background:#e8fff8;
    color:#00b894;
    padding:10px 18px;
    border-radius:30px;
    font-size:14px;
}

/* RIGHT */

.right{
    width:30%;
}

/* OWNER CARD */

.owner-card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    position:sticky;
    top:20px;
}

.owner-card h2{
    margin-bottom:20px;
}

/* OWNER INFO */

.owner-info{
    margin-bottom:15px;
}

.owner-info i{
    color:#00b894;
    margin-right:10px;
}

/* BUTTONS */

.btn{
    display:block;
    width:100%;
    text-align:center;
    padding:14px;
    border-radius:12px;
    text-decoration:none;
    margin-top:15px;
    transition:0.3s;
    font-weight:600;
}

.book-btn{
    background:#00b894;
    color:white;
}

.book-btn:hover{
    background:#00997a;
}

.chat-btn{
    background:#667eea;
    color:white;
}

.chat-btn:hover{
    background:#5a67d8;
}

/* MAP */

.map{
    margin-top:30px;
}

.map iframe{
    width:100%;
    height:300px;
    border:none;
    border-radius:15px;
}

/* RESPONSIVE */

@media(max-width:900px){

    .container{
        flex-direction:column;
    }

    .left,
    .right{
        width:100%;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .room-title{
        flex-direction:column;
        align-items:flex-start;
        gap:10px;
    }
}

</style>
</head>

<body>

<div class="container">

    <!-- LEFT SIDE -->

    <div class="left">

        <!-- IMAGE -->

        <div class="room-image">

            <img src="../assets/images/<?php echo $room['image']; ?>">

        </div>

        <!-- CONTENT -->

        <div class="content">

            <!-- TITLE -->

            <div class="room-title">

                <h1>
                    <?php echo $room['room_title']; ?>
                </h1>

                <div class="price">
                    ₹<?php echo $room['price']; ?>/month
                </div>

            </div>

            <!-- INFO -->

            <div class="info-grid">

                <div class="info-box">
                    <i class="fas fa-city"></i>
                    <b>City:</b>
                    <?php echo $room['city']; ?>
                </div>

                <div class="info-box">
                    <i class="fas fa-map-marker-alt"></i>
                    <b>Area:</b>
                    <?php echo $room['area']; ?>
                </div>

                <div class="info-box">
                    <i class="fas fa-home"></i>
                    <b>Room Type:</b>
                    <?php echo $room['room_type']; ?>
                </div>

                <div class="info-box">
                    <i class="fas fa-check-circle"></i>
                    <b>Status:</b>
                    <?php echo ucfirst($room['status']); ?>
                </div>

            </div>

            <!-- DESCRIPTION -->

            <div class="description">

                <h2>📄 Description</h2>

                <p>
                    <?php echo $room['description']; ?>
                </p>

            </div>

            <!-- AMENITIES -->

            <div class="amenities">

                <h2>✨ Amenities</h2>

                <div class="amenities-list">

                    <?php

                    $amenities = explode(",", $room['amenities']);

                    foreach($amenities as $item){

                    ?>

                    <div class="amenity">
                        <?php echo trim($item); ?>
                    </div>

                    <?php } ?>

                </div>

            </div>

            <!-- MAP -->

            <?php if(!empty($room['map'])) { ?>

            <div class="map">

                <h2>📍 Location</h2>

                <iframe
                src="<?php echo $room['map']; ?>"
                allowfullscreen>
                </iframe>

            </div>

            <?php } ?>

        </div>

    </div>

    <!-- RIGHT SIDE -->

    <div class="right">

        <div class="owner-card">

            <h2>👤 Owner Details</h2>

            <div class="owner-info">

                <i class="fas fa-user"></i>

                <?php echo $room['name']; ?>

            </div>

            <div class="owner-info">

                <i class="fas fa-phone"></i>

                <?php echo $room['phone']; ?>

            </div>

            <div class="owner-info">

                <i class="fas fa-envelope"></i>

                <?php echo $room['email']; ?>

            </div>

            <!-- BOOK BUTTON -->

            <?php if(isset($_SESSION['role']) && $_SESSION['role']=="user") { ?>

            <a href="../bookings/book_room.php?room_id=<?php echo $room['id']; ?>"
            class="btn book-btn">

                <i class="fas fa-calendar-check"></i>

                Book Room

            </a>

            <!-- CHAT BUTTON -->

            <a href="../messages/chat.php?room_id=<?php echo $room['id']; ?>&owner_id=<?php echo $room['user_id']; ?>&user_id=<?php echo $_SESSION['user_id']; ?>"
            class="btn chat-btn">

                <i class="fas fa-comments"></i>

                Chat With Owner

            </a>

            <?php } ?>

        </div>

    </div>

</div>

</body>
</html>