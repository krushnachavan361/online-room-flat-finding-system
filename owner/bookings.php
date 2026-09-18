<?php
session_start();
include("../includes/db.php");

// LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: ../user/login.php");
    exit();
}

$owner_id = $_SESSION['user_id'];

// UPDATE STATUS
if(isset($_GET['action']) && isset($_GET['id'])){

    $booking_id = $_GET['id'];
    $action = $_GET['action'];

    if($action == "accept"){

        mysqli_query($conn,
        "UPDATE bookings 
        SET status='accepted'
        WHERE id='$booking_id'");

    }

    elseif($action == "reject"){

        mysqli_query($conn,
        "UPDATE bookings 
        SET status='rejected'
        WHERE id='$booking_id'");

    }

    header("Location: bookings.php");
    exit();
}

// FETCH BOOKINGS
$query = "SELECT bookings.*, 

rooms.room_title,
rooms.city,
rooms.area,
rooms.price,
rooms.image,

users.name,
users.phone,
users.email

FROM bookings

JOIN rooms 
ON bookings.room_id = rooms.id

JOIN users 
ON bookings.user_id = users.id

WHERE bookings.owner_id='$owner_id'

ORDER BY bookings.id DESC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Owner Bookings</title>

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

/* CARD */

.booking-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    margin-bottom:30px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    display:flex;
    transition:0.3s;
}

.booking-card:hover{
    transform:translateY(-5px);
}

/* IMAGE */

.booking-image{
    width:320px;
    height:260px;
}

.booking-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* CONTENT */

.booking-content{
    flex:1;
    padding:25px;
}

/* TITLE */

.room-title{
    font-size:30px;
    font-weight:bold;
    color:#111827;
    margin-bottom:10px;
}

/* PRICE */

.price{
    color:#00b894;
    font-size:24px;
    font-weight:bold;
    margin-bottom:20px;
}

/* INFO */

.info-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
    margin-bottom:20px;
}

.info-box{
    background:#f4f6f9;
    padding:14px;
    border-radius:12px;
}

.info-box i{
    color:#00b894;
    margin-right:8px;
}

/* MESSAGE */

.message-box{
    background:#f9f9f9;
    padding:15px;
    border-radius:12px;
    margin-top:15px;
    line-height:1.7;
}

/* STATUS */

.status{
    display:inline-block;
    padding:10px 18px;
    border-radius:30px;
    color:white;
    font-size:14px;
    margin-top:15px;
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

/* BUTTONS */

.btns{
    margin-top:25px;
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.btn{
    padding:14px 20px;
    border-radius:12px;
    text-decoration:none;
    color:white;
    transition:0.3s;
    font-weight:600;
}

.accept-btn{
    background:#00b894;
}

.accept-btn:hover{
    background:#00997a;
}

.reject-btn{
    background:#e74c3c;
}

.reject-btn:hover{
    background:#c0392b;
}

.chat-btn{
    background:#667eea;
}

.chat-btn:hover{
    background:#5a67d8;
}

/* EMPTY */

.empty{
    background:white;
    padding:50px;
    text-align:center;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

.empty h2{
    color:#555;
}

/* RESPONSIVE */

@media(max-width:900px){

    .booking-card{
        flex-direction:column;
    }

    .booking-image{
        width:100%;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

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
        📅 Room Bookings
    </h1>

    <p>
        Manage all user booking requests
    </p>

</div>

<!-- CONTAINER -->

<div class="container">

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

    <!-- CARD -->

    <div class="booking-card">

        <!-- IMAGE -->

        <div class="booking-image">

            <img src="../assets/images/<?php echo $row['image']; ?>">

        </div>

        <!-- CONTENT -->

        <div class="booking-content">

            <!-- ROOM TITLE -->

            <div class="room-title">

                <?php echo $row['room_title']; ?>

            </div>

            <!-- PRICE -->

            <div class="price">

                ₹<?php echo $row['price']; ?>/month

            </div>

            <!-- INFO -->

            <div class="info-grid">

                <div class="info-box">

                    <i class="fas fa-user"></i>

                    <b>User:</b>

                    <?php echo $row['name']; ?>

                </div>

                <div class="info-box">

                    <i class="fas fa-phone"></i>

                    <b>Phone:</b>

                    <?php echo $row['phone']; ?>

                </div>

                <div class="info-box">

                    <i class="fas fa-envelope"></i>

                    <b>Email:</b>

                    <?php echo $row['email']; ?>

                </div>

                <div class="info-box">

                    <i class="fas fa-city"></i>

                    <b>City:</b>

                    <?php echo $row['city']; ?>

                </div>

                <div class="info-box">

                    <i class="fas fa-calendar"></i>

                    <b>Move Date:</b>

                    <?php echo $row['move_date']; ?>

                </div>

                <div class="info-box">

                    <i class="fas fa-users"></i>

                    <b>Members:</b>

                    <?php echo $row['members']; ?>

                </div>

            </div>

            <!-- MESSAGE -->

            <div class="message-box">

                <b>Message:</b><br>

                <?php echo $row['message']; ?>

            </div>

            <!-- STATUS -->

            <div>

                <span class="status <?php echo $row['status']; ?>">

                    <?php echo ucfirst($row['status']); ?>

                </span>

            </div>

            <!-- BUTTONS -->

            <div class="btns">

                <?php if($row['status'] == "pending"){ ?>

                <!-- ACCEPT -->

                <a href="bookings.php?action=accept&id=<?php echo $row['id']; ?>"
                class="btn accept-btn">

                    <i class="fas fa-check"></i>

                    Accept

                </a>

                <!-- REJECT -->

                <a href="bookings.php?action=reject&id=<?php echo $row['id']; ?>"
                class="btn reject-btn">

                    <i class="fas fa-times"></i>

                    Reject

                </a>

                <?php } ?>

                <!-- CHAT -->

                <a href="../messages/chat.php?room_id=<?php echo $row['room_id']; ?>&owner_id=<?php echo $owner_id; ?>&user_id=<?php echo $row['user_id']; ?>"
                class="btn chat-btn">

                    <i class="fas fa-comments"></i>

                    Chat User

                </a>

            </div>

        </div>

    </div>

<?php } ?>

<?php } else { ?>

<!-- EMPTY -->

<div class="empty">

    <h2>
        ❌ No Booking Requests Found
    </h2>

</div>

<?php } ?>

</div>

</body>
</html>