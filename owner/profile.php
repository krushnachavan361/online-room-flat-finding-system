<?php
include("../includes/owner_auth.php");
include("../includes/db.php");

$owner_id = $_SESSION['user_id'];

// FETCH OWNER
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM users WHERE id='$owner_id'"));

// UPDATE PROFILE
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    mysqli_query($conn,
    "UPDATE users SET 
    name='$name',
    email='$email',
    phone='$phone',
    address='$address'
    WHERE id='$owner_id'");

    header("Location: profile.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Owner Profile</title>

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
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:250px;
    height:100vh;
    background:#111827;
    color:white;
    position:fixed;
    padding-top:20px;
}

.logo{
    text-align:center;
    font-size:24px;
    margin-bottom:30px;
    color:#00ffcc;
    font-weight:bold;
}

.sidebar a{
    display:block;
    color:white;
    padding:15px 25px;
    text-decoration:none;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1f2937;
    color:#00ffcc;
}

/* MAIN */
.main{
    margin-left:250px;
    width:100%;
    padding:30px;
}

/* PROFILE CARD */
.profile-box{
    max-width:600px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.profile-header{
    text-align:center;
    margin-bottom:30px;
}

.profile-header i{
    font-size:80px;
    color:#00b894;
    margin-bottom:10px;
}

.profile-header h2{
    color:#111827;
}

/* FORM */
.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

.form-group input,
.form-group textarea{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:15px;
}

textarea{
    resize:none;
    height:100px;
}

/* BUTTON */
.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#00b894;
    color:white;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#00997a;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">Owner Panel</div>

    <a href="dashboard.php">
        <i class="fas fa-chart-line"></i> Dashboard
    </a>

    <a href="../rooms/add_room.php">
        <i class="fas fa-plus"></i> Add Room
    </a>

    <a href="../rooms/view_rooms.php">
        <i class="fas fa-home"></i> My Rooms
    </a>

    <a href="bookings.php">
        <i class="fas fa-calendar-check"></i> Bookings
    </a>

    <a href="../messages/inbox.php">
        <i class="fas fa-comments"></i> Messages
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

    <div class="profile-box">

        <!-- PROFILE HEADER -->
        <div class="profile-header">

            <i class="fas fa-user-circle"></i>

            <h2>Owner Profile</h2>

        </div>

        <!-- FORM -->
        <form method="POST">

            <div class="form-group">
                <label>Full Name</label>

                <input type="text"
                name="name"
                value="<?php echo $user['name']; ?>"
                required>
            </div>

            <div class="form-group">
                <label>Email</label>

                <input type="email"
                name="email"
                value="<?php echo $user['email']; ?>"
                required>
            </div>

            <div class="form-group">
                <label>Phone</label>

                <input type="text"
                name="phone"
                value="<?php echo $user['phone']; ?>">
            </div>

            <div class="form-group">
                <label>Address</label>

                <textarea name="address"><?php echo $user['address']; ?></textarea>
            </div>

            <button type="submit" name="update" class="btn">
                Update Profile
            </button>

        </form>

    </div>

</div>

</body>
</html>