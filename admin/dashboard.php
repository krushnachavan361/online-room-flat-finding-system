<?php
session_start();
include("../includes/db.php");

// ADMIN CHECK
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin"){
    header("Location: ../user/login.php");
    exit();
}

// TOTAL USERS
$total_users = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM users WHERE role='user'"));

// TOTAL OWNERS
$total_owners = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM users WHERE role='owner'"));

// TOTAL ROOMS
$total_rooms = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM rooms"));

// TOTAL BOOKINGS
$total_bookings = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM bookings"));

// TOTAL MESSAGES
$total_messages = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM messages"));

// AVAILABLE ROOMS
$available_rooms = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM rooms WHERE status='available'"));

// OCCUPIED ROOMS
$occupied_rooms = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM rooms WHERE status='occupied'"));

// RECENT BOOKINGS
$recent_bookings = mysqli_query($conn,

"SELECT bookings.*,

users.name,

rooms.room_title

FROM bookings

JOIN users
ON bookings.user_id = users.id

JOIN rooms
ON bookings.room_id = rooms.id

ORDER BY bookings.id DESC

LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- ICON -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f4f6f9;
    display:flex;
}

/* SIDEBAR */

.sidebar{
    width:260px;
    height:100vh;
    background:#111827;
    position:fixed;
    padding-top:20px;
}

.logo{
    text-align:center;
    color:#00ffcc;
    font-size:26px;
    font-weight:bold;
    margin-bottom:35px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:16px 25px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1f2937;
    color:#00ffcc;
}

/* MAIN */

.main{
    margin-left:260px;
    width:100%;
    padding:25px;
}

/* TOPBAR */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.admin-box{
    background:white;
    padding:12px 18px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

/* WELCOME */

.welcome{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:25px;
}

/* CARDS */

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

/* CARD */

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card i{
    font-size:35px;
    color:#00b894;
    margin-bottom:15px;
}

.card h3{
    margin-bottom:10px;
    color:#111827;
}

.count{
    font-size:32px;
    font-weight:bold;
}

/* BOX */

.box{
    margin-top:30px;
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

/* TABLE */

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

table th{
    background:#111827;
    color:white;
    padding:14px;
}

table td{
    padding:14px;
    border-bottom:1px solid #eee;
    text-align:center;
}

/* STATUS */

.pending{
    color:orange;
    font-weight:bold;
}

.accepted{
    color:green;
    font-weight:bold;
}

.rejected{
    color:red;
    font-weight:bold;
}

</style>
</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">

        Admin Panel

    </div>

    <a href="dashboard.php">

        <i class="fas fa-chart-line"></i>

        Dashboard

    </a>

    <a href="manage_users.php">

        <i class="fas fa-users"></i>

        Manage Users

    </a>

    <a href="manage_rooms.php">

        <i class="fas fa-home"></i>

        Manage Rooms

    </a>

    <a href="manage_bookings.php">

        <i class="fas fa-calendar-check"></i>

        Manage Bookings

    </a>

    <a href="../messages/inbox.php">

        <i class="fas fa-comments"></i>

        Messages

    </a>

    <a href="../logout.php">

        <i class="fas fa-sign-out-alt"></i>

        Logout

    </a>

</div>

<!-- MAIN -->

<div class="main">

    <!-- TOPBAR -->

    <div class="topbar">

        <h2>
            📊 Admin Dashboard
        </h2>

        <div class="admin-box">

            👨‍💼 Administrator

        </div>

    </div>

    <!-- WELCOME -->

    <div class="welcome">

        <h1>
            Welcome Admin 👋
        </h1>

        <p>
            Monitor all activities of Room Rental System
        </p>

    </div>

    <!-- CARDS -->

    <div class="cards">

        <!-- USERS -->

        <div class="card">

            <i class="fas fa-users"></i>

            <h3>Total Users</h3>

            <div class="count">

                <?php echo $total_users; ?>

            </div>

        </div>

        <!-- OWNERS -->

        <div class="card">

            <i class="fas fa-user-tie"></i>

            <h3>Total Owners</h3>

            <div class="count">

                <?php echo $total_owners; ?>

            </div>

        </div>

        <!-- ROOMS -->

        <div class="card">

            <i class="fas fa-home"></i>

            <h3>Total Rooms</h3>

            <div class="count">

                <?php echo $total_rooms; ?>

            </div>

        </div>

        <!-- BOOKINGS -->

        <div class="card">

            <i class="fas fa-calendar-check"></i>

            <h3>Total Bookings</h3>

            <div class="count">

                <?php echo $total_bookings; ?>

            </div>

        </div>

        <!-- MESSAGES -->

        <div class="card">

            <i class="fas fa-comments"></i>

            <h3>Total Messages</h3>

            <div class="count">

                <?php echo $total_messages; ?>

            </div>

        </div>

        <!-- AVAILABLE -->

        <div class="card">

            <i class="fas fa-check-circle"></i>

            <h3>Available Rooms</h3>

            <div class="count">

                <?php echo $available_rooms; ?>

            </div>

        </div>

        <!-- OCCUPIED -->

        <div class="card">

            <i class="fas fa-times-circle"></i>

            <h3>Occupied Rooms</h3>

            <div class="count">

                <?php echo $occupied_rooms; ?>

            </div>

        </div>

    </div>

    <!-- CHART -->

    <div class="box">

        <h2>
            📈 Analytics Overview
        </h2>

        <canvas id="chart"></canvas>

    </div>

    <!-- RECENT BOOKINGS -->

    <div class="box">

        <h2>
            📅 Recent Bookings
        </h2>

        <table>

            <tr>

                <th>User</th>

                <th>Room</th>

                <th>Status</th>

            </tr>

            <?php while($row = mysqli_fetch_assoc($recent_bookings)){ ?>

            <tr>

                <td>

                    <?php echo $row['name']; ?>

                </td>

                <td>

                    <?php echo $row['room_title']; ?>

                </td>

                <td class="<?php echo $row['status']; ?>">

                    <?php echo ucfirst($row['status']); ?>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

<!-- CHART SCRIPT -->

<script>

const ctx = document.getElementById('chart');

new Chart(ctx, {

    type:'bar',

    data:{
        labels:[
            'Users',
            'Owners',
            'Rooms',
            'Bookings',
            'Messages'
        ],

        datasets:[{

            label:'System Analytics',

            data:[
                <?php echo $total_users; ?>,
                <?php echo $total_owners; ?>,
                <?php echo $total_rooms; ?>,
                <?php echo $total_bookings; ?>,
                <?php echo $total_messages; ?>
            ],

            borderWidth:1
        }]
    },

    options:{
        responsive:true
    }

});

</script>

</body>
</html>