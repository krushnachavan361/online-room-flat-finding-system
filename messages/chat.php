<?php
session_start();
include("../includes/db.php");

// LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: ../user/login.php");
    exit();
}

$current_user = $_SESSION['user_id'];

// GET DATA
$room_id = $_GET['room_id'];
$owner_id = $_GET['owner_id'];
$user_id = $_GET['user_id'];

// DETERMINE CHAT RECEIVER
if($current_user == $owner_id){

    $receiver_id = $user_id;

}else{

    $receiver_id = $owner_id;
}

// FETCH ROOM
$room_query = mysqli_query($conn,
"SELECT * FROM rooms WHERE id='$room_id'");

$room = mysqli_fetch_assoc($room_query);

// FETCH RECEIVER
$user_query = mysqli_query($conn,
"SELECT * FROM users WHERE id='$receiver_id'");

$receiver = mysqli_fetch_assoc($user_query);

// SEND MESSAGE
if(isset($_POST['send'])){

    $message = trim($_POST['message']);

    if(!empty($message)){

        mysqli_query($conn,
        "INSERT INTO messages
        (
            sender_id,
            receiver_id,
            room_id,
            message
        )

        VALUES
        (
            '$current_user',
            '$receiver_id',
            '$room_id',
            '$message'
        )");
    }

    header("Location: chat.php?room_id=$room_id&owner_id=$owner_id&user_id=$user_id");
    exit();
}

// FETCH MESSAGES
$messages = mysqli_query($conn,
"SELECT * FROM messages

WHERE room_id='$room_id'

AND
(
(sender_id='$current_user' AND receiver_id='$receiver_id')

OR

(sender_id='$receiver_id' AND receiver_id='$current_user')
)

ORDER BY created_at ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Chat</title>

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

/* CONTAINER */

.chat-container{
    width:90%;
    max-width:1000px;
    height:90vh;
    margin:20px auto;
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    display:flex;
    flex-direction:column;
}

/* HEADER */

.chat-header{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    padding:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.user-info{
    display:flex;
    align-items:center;
    gap:15px;
}

.avatar{
    width:55px;
    height:55px;
    border-radius:50%;
    background:white;
    color:#667eea;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:24px;
    font-weight:bold;
}

/* ROOM */

.room-name{
    font-size:14px;
    opacity:0.9;
}

/* CHAT BODY */

.chat-body{
    flex:1;
    padding:20px;
    overflow-y:auto;
    background:#eef1f5;
}

/* MESSAGE */

.message{
    margin-bottom:18px;
    display:flex;
}

.message.sent{
    justify-content:flex-end;
}

.message.received{
    justify-content:flex-start;
}

/* BUBBLE */

.bubble{
    max-width:70%;
    padding:14px 18px;
    border-radius:18px;
    position:relative;
    font-size:15px;
    line-height:1.6;
}

.sent .bubble{
    background:#667eea;
    color:white;
    border-bottom-right-radius:5px;
}

.received .bubble{
    background:white;
    color:#111827;
    border-bottom-left-radius:5px;
}

/* TIME */

.time{
    font-size:11px;
    margin-top:8px;
    opacity:0.7;
}

/* FORM */

.chat-form{
    background:white;
    padding:20px;
    border-top:1px solid #ddd;
    display:flex;
    gap:15px;
}

.chat-form input{
    flex:1;
    padding:15px;
    border-radius:30px;
    border:1px solid #ccc;
    outline:none;
    font-size:15px;
}

.chat-form button{
    width:60px;
    border:none;
    border-radius:50%;
    background:#00b894;
    color:white;
    font-size:20px;
    cursor:pointer;
    transition:0.3s;
}

.chat-form button:hover{
    background:#00997a;
}

/* EMPTY */

.empty{
    text-align:center;
    margin-top:50px;
    color:#777;
}

/* RESPONSIVE */

@media(max-width:768px){

    .bubble{
        max-width:90%;
    }

    .chat-container{
        width:95%;
        height:95vh;
    }
}

</style>
</head>

<body>

<div class="chat-container">

    <!-- HEADER -->

    <div class="chat-header">

        <div class="user-info">

            <div class="avatar">

                <?php echo strtoupper(substr($receiver['name'],0,1)); ?>

            </div>

            <div>

                <h2>
                    <?php echo $receiver['name']; ?>
                </h2>

                <div class="room-name">

                    🏠 <?php echo $room['room_title']; ?>

                </div>

            </div>

        </div>

        <div>

            <i class="fas fa-comments"></i>

        </div>

    </div>

    <!-- CHAT BODY -->

    <div class="chat-body">

        <?php if(mysqli_num_rows($messages) > 0){ ?>

        <?php while($msg = mysqli_fetch_assoc($messages)){ ?>

            <div class="message 

            <?php

            if($msg['sender_id'] == $current_user){

                echo "sent";

            }else{

                echo "received";
            }

            ?>">

                <div class="bubble">

                    <?php echo $msg['message']; ?>

                    <div class="time">

                        <?php

                        echo date("d M h:i A",
                        strtotime($msg['created_at']));

                        ?>

                    </div>

                </div>

            </div>

        <?php } ?>

        <?php } else { ?>

        <div class="empty">

            <h3>
                💬 No Messages Yet
            </h3>

            <p>
                Start your conversation now.
            </p>

        </div>

        <?php } ?>

    </div>

    <!-- FORM -->

    <form method="POST" class="chat-form">

        <input type="text"
        name="message"
        placeholder="Type your message..."
        required>

        <button type="submit"
        name="send">

            <i class="fas fa-paper-plane"></i>

        </button>

    </form>

</div>

</body>
</html>