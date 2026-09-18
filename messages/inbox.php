<?php
session_start();
include("../includes/db.php");

// LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH CHAT USERS
$query = "SELECT DISTINCT

IF(sender_id='$user_id', receiver_id, sender_id)
AS chat_user,

room_id

FROM messages

WHERE sender_id='$user_id'
OR receiver_id='$user_id'

ORDER BY id DESC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Inbox</title>

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
    max-width:900px;
    margin:40px auto;
}

/* CHAT CARD */

.chat-card{
    background:white;
    border-radius:18px;
    padding:20px;
    margin-bottom:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}

.chat-card:hover{
    transform:translateY(-4px);
}

/* LEFT */

.left{
    display:flex;
    align-items:center;
    gap:18px;
}

/* AVATAR */

.avatar{
    width:65px;
    height:65px;
    border-radius:50%;
    background:#667eea;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:24px;
    font-weight:bold;
}

/* INFO */

.info h2{
    color:#111827;
    margin-bottom:5px;
}

.room{
    color:#666;
    margin-bottom:6px;
}

.last-msg{
    color:#888;
    font-size:14px;
}

/* BUTTON */

.btn{
    background:#00b894;
    color:white;
    padding:12px 20px;
    border-radius:12px;
    text-decoration:none;
    transition:0.3s;
    font-weight:600;
}

.btn:hover{
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

@media(max-width:768px){

    .chat-card{
        flex-direction:column;
        gap:20px;
        align-items:flex-start;
    }

    .btn{
        width:100%;
        text-align:center;
    }
}

</style>
</head>

<body>

<!-- HEADER -->

<div class="header">

    <h1>
        📩 Inbox
    </h1>

    <p>
        Manage all your conversations
    </p>

</div>

<!-- CONTAINER -->

<div class="container">

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<?php

$other_id = $row['chat_user'];

$room_id = $row['room_id'];

// FETCH USER
$user_query = mysqli_query($conn,
"SELECT * FROM users WHERE id='$other_id'");

$user = mysqli_fetch_assoc($user_query);

// FETCH ROOM
$room_query = mysqli_query($conn,
"SELECT * FROM rooms WHERE id='$room_id'");

$room = mysqli_fetch_assoc($room_query);

// LAST MESSAGE
$msg_query = mysqli_query($conn,
"SELECT * FROM messages

WHERE room_id='$room_id'

AND
(
(sender_id='$user_id' AND receiver_id='$other_id')

OR

(sender_id='$other_id' AND receiver_id='$user_id')
)

ORDER BY created_at DESC
LIMIT 1");

$msg = mysqli_fetch_assoc($msg_query);

?>

<!-- CHAT CARD -->

<div class="chat-card">

    <!-- LEFT -->

    <div class="left">

        <!-- AVATAR -->

        <div class="avatar">

            <?php echo strtoupper(substr($user['name'],0,1)); ?>

        </div>

        <!-- INFO -->

        <div class="info">

            <h2>

                <?php echo $user['name']; ?>

            </h2>

            <div class="room">

                🏠 <?php echo $room['room_title']; ?>

            </div>

            <div class="last-msg">

                <?php echo substr($msg['message'],0,50); ?>

            </div>

        </div>

    </div>

    <!-- BUTTON -->

    <a href="chat.php?room_id=<?php echo $room_id; ?>&owner_id=<?php echo $room['user_id']; ?>&user_id=<?php echo $other_id; ?>"
    class="btn">

        <i class="fas fa-comments"></i>

        Open Chat

    </a>

</div>

<?php } ?>

<?php } else { ?>

<!-- EMPTY -->

<div class="empty">

    <h2>
        ❌ No Conversations Yet
    </h2>

</div>

<?php } ?>

</div>

</body>
</html>