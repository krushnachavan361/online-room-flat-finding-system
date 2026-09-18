<?php
session_start();
include("../includes/db.php");

if (isset($_POST['register'])) {

    $name     = trim($_POST['name']);
    $address  = trim($_POST['address']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $role     = trim($_POST['role']);

    // CHECK EMAIL
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {

        $error = "Email already exists!";

    } else {

        $query = "INSERT INTO users (name, address, email, phone, password, role)
                  VALUES ('$name', '$address', '$email', '$phone', '$password', '$role')";

        if (mysqli_query($conn, $query)) {

            $success = "Registration Successful!";

        } else {

            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Premium Register</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    overflow:hidden;
}

.container{
    width:1050px;
    height:650px;
    background:white;
    border-radius:25px;
    overflow:hidden;
    display:flex;
    box-shadow:0 25px 50px rgba(0,0,0,0.4);
}

/* LEFT SIDE */

.left{
    width:50%;
    background:linear-gradient(135deg,#ff512f,#dd2476);
    color:white;
    padding:60px 40px;
    position:relative;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.logo{
    font-size:28px;
    font-weight:700;
    margin-bottom:25px;
}

.left h1{
    font-size:42px;
    line-height:1.3;
    margin-bottom:20px;
}

.left p{
    font-size:16px;
    line-height:1.8;
    opacity:0.9;
}

.circle1,
.circle2{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,0.1);
}

.circle1{
    width:220px;
    height:220px;
    top:-70px;
    right:-70px;
}

.circle2{
    width:170px;
    height:170px;
    bottom:-40px;
    left:-40px;
}

/* RIGHT SIDE */

.right{
    width:50%;
    padding:45px 50px;
    overflow-y:auto;
}

.right h2{
    font-size:34px;
    color:#333;
    margin-bottom:10px;
}

.right p{
    color:#777;
    margin-bottom:25px;
}

.input-box{
    margin-bottom:18px;
}

.input-box label{
    display:block;
    margin-bottom:8px;
    font-weight:500;
    color:#444;
}

.input-box input,
.input-box select{
    width:100%;
    padding:14px;
    border-radius:12px;
    border:1px solid #ddd;
    outline:none;
    font-size:15px;
    transition:0.3s;
}

.input-box input:focus,
.input-box select:focus{
    border-color:#dd2476;
    box-shadow:0 0 10px rgba(221,36,118,0.3);
}

.btn{
    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#ff512f,#dd2476);
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(0,0,0,0.2);
}

.msg{
    padding:12px;
    border-radius:10px;
    margin-bottom:15px;
    font-size:14px;
}

.error{
    background:#ffe5e5;
    color:#d8000c;
}

.success{
    background:#e5ffe8;
    color:#008000;
}

.bottom{
    margin-top:20px;
    text-align:center;
    color:#666;
}

.bottom a{
    color:#dd2476;
    text-decoration:none;
    font-weight:600;
}

@media(max-width:900px){

    .container{
        width:95%;
        height:auto;
        flex-direction:column;
    }

    .left,
    .right{
        width:100%;
    }

    .left{
        padding:40px;
    }

    .right{
        padding:40px;
    }
}

</style>
</head>

<body>

<div class="container">

<!-- LEFT SIDE -->

<div class="left">

    <div class="circle1"></div>
    <div class="circle2"></div>

    <div class="logo">🏠 Room Finder</div>

    <h1>Create Your Dream Space Today</h1>

    <p>
        Join our smart room rental platform to 
        explore rooms, connect with owners, 
        and manage bookings easily and securely.
    </p>

</div>

<!-- RIGHT SIDE -->

<div class="right">

    <h2>Create Account</h2>
    <p>Register to continue</p>

    <?php if(isset($error)){ ?>
        <div class="msg error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <?php if(isset($success)){ ?>
        <div class="msg success">
            <?php echo $success; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <div class="input-box">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="Enter Full Name" required>
        </div>

        <div class="input-box">
            <label>Address</label>
            <input type="text" name="address" placeholder="Enter Address" required>
        </div>

        <div class="input-box">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter Email Address" required>
        </div>

        <div class="input-box">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="Enter Phone Number" required>
        </div>

        <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter Password" required>
        </div>

        <div class="input-box">
            <label>Select Role</label>

            <select name="role" required>
                <option value="">Choose Role</option>
                <option value="user">User</option>
                <option value="owner">Owner</option>
            </select>
        </div>

        <button type="submit" name="register" class="btn">
            Create Account
        </button>

    </form>

    <div class="bottom">
        Already have an account?
        <a href="login.php">Login</a>
    </div>

</div>

</div>

</body>
</html>