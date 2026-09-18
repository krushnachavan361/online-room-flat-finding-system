<?php
include("../includes/user_auth.php");
include("../includes/db.php");

$user_id = $_SESSION['user_id'];

// USER DETAILS
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM users WHERE id='$user_id'"));

// TOTAL BOOKINGS
$total_bookings = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM bookings WHERE user_id='$user_id'"));

// TOTAL MESSAGES
$total_messages = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM messages 
WHERE sender_id='$user_id' 
OR receiver_id='$user_id'"));

// RECENT BOOKINGS
$recent_bookings = mysqli_query($conn,
"SELECT b.*, r.room_title, r.city, r.price
FROM bookings b
JOIN rooms r ON b.room_id = r.id
WHERE b.user_id='$user_id'
ORDER BY b.created_at DESC
LIMIT 5");

?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>

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

/* SIDEBAR */

.sidebar{
    position:fixed;
    width:250px;
    height:100vh;
    background:#111827;
    color:white;
    padding-top:20px;
}

.logo{
    text-align:center;
    font-size:24px;
    font-weight:bold;
    color:#00ffcc;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px 25px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1f2937;
    color:#00ffcc;
}

/* MAIN */

.main{
    margin-left:250px;
    padding:25px;
}

/* TOPBAR */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.profile{
    background:white;
    padding:10px 20px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

/* WELCOME */

.welcome{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    padding:25px;
    border-radius:15px;
    margin-bottom:25px;
}

/* CARDS */

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

.card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card i{
    font-size:30px;
    color:#00b894;
    margin-bottom:10px;
}

.card h3{
    margin-bottom:10px;
}

.count{
    font-size:28px;
    font-weight:bold;
}

/* TABLE */

.table-box{
    margin-top:30px;
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table th,
table td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

table th{
    background:#111827;
    color:white;
}

.status{
    padding:5px 10px;
    border-radius:20px;
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

</style>
</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">
        User Panel
    </div>

    <a href="dashboard.php">
        <i class="fas fa-home"></i> Dashboard
    </a>

    <a href="../rooms/view_rooms.php">
        <i class="fas fa-building"></i> View Rooms
    </a>

    <a href="my_bookings.php">
        <i class="fas fa-calendar-check"></i> My Bookings
    </a>

    <a href="../messages/inbox.php">
        <i class="fas fa-comments"></i> Inbox
    </a>

    <a href="profile.php">
        <i class="fas fa-user"></i> Profile
    </a>

    <a href="../logout.php">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>

</div>

<!-- MAIN -->

<div class="main">

    <!-- TOPBAR -->

    <div class="topbar">

        <h2>🏠 User Dashboard</h2>

        <div class="profile">
            👤 <?php echo $user['name']; ?>
        </div>

    </div>

    <!-- WELCOME -->

    <div class="welcome">

        <h2>
            Welcome Back, <?php echo $user['name']; ?> 👋
        </h2>

        <p>
            Manage your bookings and explore premium rooms.
        </p>

    </div>

    <!-- CARDS -->

    <div class="cards">

        <div class="card">

            <i class="fas fa-calendar-check"></i>

            <h3>Total Bookings</h3>

            <div class="count">
                <?php echo $total_bookings; ?>
            </div>

        </div>

        <div class="card">

            <i class="fas fa-comments"></i>

            <h3>Total Messages</h3>

            <div class="count">
                <?php echo $total_messages; ?>
            </div>

        </div>

    </div>

    <!-- RECENT BOOKINGS -->

    <div class="table-box">

        <h3>📥 Recent Bookings</h3>

        <table>

            <tr>
                <th>Room</th>
                <th>City</th>
                <th>Price</th>
                <th>Status</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($recent_bookings)) { ?>

            <tr>

                <td>
                    <?php echo $row['room_title']; ?>
                </td>

                <td>
                    <?php echo $row['city']; ?>
                </td>

                <td>
                    ₹<?php echo $row['price']; ?>
                </td>

                <td>

                    <span class="status <?php echo $row['status']; ?>">

                        <?php echo ucfirst($row['status']); ?>

                    </span>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>