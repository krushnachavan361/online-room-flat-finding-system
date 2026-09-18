<?php
session_start();
include("../includes/db.php");

// LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH BOOKINGS
$query = "SELECT bookings.*, 
rooms.room_title,
rooms.city,
rooms.area,
rooms.price,
rooms.image,
users.name AS owner_name,
users.phone AS owner_phone

FROM bookings

JOIN rooms 
ON bookings.room_id = rooms.id

JOIN users 
ON bookings.owner_id = users.id

WHERE bookings.user_id='$user_id'

ORDER BY bookings.id DESC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bookings</title>

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

/* BOOKING CARD */

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
    height:250px;
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

/* INFO GRID */

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

/* STATUS */

.status{
    display:inline-block;
    padding:10px 18px;
    border-radius:30px;
    color:white;
    font-size:14px;
    margin-top:10px;
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
}

.btn{
    padding:14px 20px;
    border-radius:12px;
    text-decoration:none;
    color:white;
    transition:0.3s;
    font-weight:600;
}

.chat-btn{
    background:#667eea;
}

.chat-btn:hover{
    background:#5a67d8;
}

.view-btn{
    background:#00b894;
}

.view-btn:hover{
    background:#00997a;
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
        📅 My Bookings
    </h1>

    <p>
        View all your booked rooms
    </p>

</div>

<!-- CONTAINER -->

<div class="container">

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

    <!-- BOOKING CARD -->

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

                    <i class="fas fa-city"></i>

                    <b>City:</b>

                    <?php echo $row['city']; ?>

                </div>

                <div class="info-box">

                    <i class="fas fa-map-marker-alt"></i>

                    <b>Area:</b>

                    <?php echo $row['area']; ?>

                </div>

                <div class="info-box">

                    <i class="fas fa-user"></i>

                    <b>Owner:</b>

                    <?php echo $row['owner_name']; ?>

                </div>

                <div class="info-box">

                    <i class="fas fa-phone"></i>

                    <b>Phone:</b>

                    <?php echo $row['owner_phone']; ?>

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

            <!-- STATUS -->

            <span class="status <?php echo $row['status']; ?>">

                <?php echo ucfirst($row['status']); ?>

            </span>

            <!-- BUTTONS -->

            <div class="btns">

                <!-- VIEW ROOM -->

                <a href="../rooms/room_details.php?id=<?php echo $row['room_id']; ?>"
                class="btn view-btn">

                    <i class="fas fa-eye"></i>

                    View Room

                </a>

                <!-- CHAT -->

                <a href="../messages/chat.php?room_id=<?php echo $row['room_id']; ?>&owner_id=<?php echo $row['owner_id']; ?>&user_id=<?php echo $user_id; ?>"
                class="btn chat-btn">

                    <i class="fas fa-comments"></i>

                    Chat Owner

                </a>

            </div>

        </div>

    </div>

<?php } ?>

<?php } else { ?>

<!-- EMPTY -->

<div class="empty">

    <h2>
        ❌ No Bookings Found
    </h2>

</div>

<?php } ?>

</div>

</body>
</html>