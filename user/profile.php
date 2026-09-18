<?php
include("../includes/auth.php");
include("../includes/db.php");

$user_id = $_SESSION['user_id'];

// FETCH USER
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM users WHERE id='$user_id'"));

// UPDATE PROFILE
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // IMAGE UPLOAD
    if(!empty($_FILES['image']['name'])){

        $image = time() . "_" . $_FILES['image']['name'];

        $tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp,
        "../assets/images/" . $image);

        mysqli_query($conn,
        "UPDATE users SET
        image='$image'
        WHERE id='$user_id'");
    }

    // UPDATE INFO
    mysqli_query($conn,
    "UPDATE users SET
    name='$name',
    email='$email',
    phone='$phone',
    address='$address'
    WHERE id='$user_id'");

    header("Location: profile.php");
}

// CHANGE PASSWORD
if(isset($_POST['change_password'])){

    $old = $_POST['old_password'];
    $new = $_POST['new_password'];

    $check = mysqli_query($conn,
    "SELECT * FROM users
    WHERE id='$user_id'
    AND password='$old'");

    if(mysqli_num_rows($check)>0){

        mysqli_query($conn,
        "UPDATE users SET
        password='$new'
        WHERE id='$user_id'");

        $success = "Password Updated Successfully";

    }else{

        $error = "Old Password Incorrect";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Advanced User Profile</title>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- ICONS -->
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

/* PROFILE BOX */
.profile-box{
    max-width:700px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

/* PROFILE IMAGE */
.profile-image{
    text-align:center;
    margin-bottom:20px;
}

.profile-image img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #00b894;
}

/* TITLE */
.title{
    text-align:center;
    margin-bottom:25px;
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

/* MESSAGE */
.success{
    background:#d4edda;
    color:#155724;
    padding:10px;
    border-radius:10px;
    margin-bottom:15px;
}

.error{
    background:#f8d7da;
    color:#721c24;
    padding:10px;
    border-radius:10px;
    margin-bottom:15px;
}

/* PASSWORD BOX */
.password-box{
    margin-top:40px;
    padding-top:20px;
    border-top:2px solid #eee;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">User Panel</div>

    <a href="dashboard.php">
        <i class="fas fa-chart-line"></i> Dashboard
    </a>

    <a href="../rooms/view_rooms.php">
        <i class="fas fa-home"></i> Explore Rooms
    </a>

    <a href="bookings.php">
        <i class="fas fa-calendar-check"></i> My Bookings
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

        <!-- PROFILE IMAGE -->
        <div class="profile-image">

            <?php if(!empty($user['image'])) { ?>

                <img src="../assets/images/<?php echo $user['image']; ?>">

            <?php } else { ?>

                <img src="../assets/images/user.png">

            <?php } ?>

        </div>

        <!-- TITLE -->
        <div class="title">
            <h2>👤 Advanced Profile</h2>
        </div>

        <!-- MESSAGE -->
        <?php if(isset($success)) { ?>
            <div class="success">
                <?php echo $success; ?>
            </div>
        <?php } ?>

        <?php if(isset($error)) { ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <!-- PROFILE FORM -->
        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Profile Image</label>

                <input type="file" name="image">
            </div>

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

            <button type="submit"
            name="update"
            class="btn">
                Update Profile
            </button>

        </form>

        <!-- PASSWORD SECTION -->
        <div class="password-box">

            <h3>🔒 Change Password</h3>

            <br>

            <form method="POST">

                <div class="form-group">

                    <label>Old Password</label>

                    <input type="password"
                    name="old_password"
                    required>

                </div>

                <div class="form-group">

                    <label>New Password</label>

                    <input type="password"
                    name="new_password"
                    required>

                </div>

                <button type="submit"
                name="change_password"
                class="btn">
                    Change Password
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>