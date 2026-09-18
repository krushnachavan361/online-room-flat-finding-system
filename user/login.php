<?php
session_start();
include("../includes/db.php");

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        // Check blocked
        if ($row['status'] == 'blocked') {
            $error = "❌ Your account is blocked by admin!";
        } else {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['name'];

            // Role Redirect
            if ($row['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } elseif ($row['role'] == 'owner') {
                header("Location: ../owner/dashboard.php");
            } else {
                header("Location: ../user/dashboard.php");
            }

            exit();
        }

    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Premium Login</title>

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
            background:linear-gradient(135deg,#141e30,#243b55);
            overflow:hidden;
        }

        .container{
            width:950px;
            height:550px;
            background:white;
            border-radius:20px;
            overflow:hidden;
            display:flex;
            box-shadow:0 25px 50px rgba(0,0,0,0.4);
        }

        /* LEFT SIDE */

        .left{
            width:50%;
            background:linear-gradient(135deg,#667eea,#764ba2);
            color:white;
            padding:60px 40px;
            position:relative;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .left h1{
            font-size:42px;
            margin-bottom:20px;
            line-height:1.3;
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
            width:200px;
            height:200px;
            top:-60px;
            right:-60px;
        }

        .circle2{
            width:160px;
            height:160px;
            bottom:-40px;
            left:-40px;
        }

        /* RIGHT SIDE */

        .right{
            width:50%;
            padding:60px 50px;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .right h2{
            font-size:34px;
            margin-bottom:10px;
            color:#333;
        }

        .right p{
            color:#777;
            margin-bottom:25px;
        }

        .input-box{
            margin-bottom:20px;
        }

        .input-box label{
            display:block;
            margin-bottom:8px;
            font-weight:500;
            color:#444;
        }

        .input-box input{
            width:100%;
            padding:14px;
            border-radius:10px;
            border:1px solid #ddd;
            outline:none;
            font-size:15px;
            transition:0.3s;
        }

        .input-box input:focus{
            border-color:#667eea;
            box-shadow:0 0 10px rgba(102,126,234,0.3);
        }

        .btn{
            width:100%;
            padding:14px;
            border:none;
            border-radius:10px;
            background:linear-gradient(135deg,#667eea,#764ba2);
            color:white;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        .btn:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 20px rgba(0,0,0,0.2);
        }

        .error{
            background:#ffe5e5;
            color:#d8000c;
            padding:10px;
            border-radius:8px;
            margin-bottom:15px;
            font-size:14px;
        }

        .bottom{
            margin-top:20px;
            text-align:center;
            color:#666;
        }

        .bottom a{
            color:#667eea;
            text-decoration:none;
            font-weight:600;
        }

        .logo{
            font-size:24px;
            font-weight:700;
            margin-bottom:30px;
        }

        @media(max-width:900px){

            .container{
                width:90%;
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

    <!-- LEFT -->
    <div class="left">

        <div class="circle1"></div>
        <div class="circle2"></div>

        <div class="logo">🏠 Room Finder</div>

        <h1>Find Your Perfect Room Easily</h1>

        <p>
            Search rooms, connect with owners, 
            and book your ideal place through our 
            smart room rental platform.
        </p>

    </div>

    <!-- RIGHT -->
    <div class="right">

        <h2>Welcome Back</h2>
        <p>Login to continue</p>

        <?php if(isset($error)){ ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="input-box">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter Email" required>
            </div>

            <div class="input-box">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>

            <button type="submit" name="login" class="btn">
                Login Now
            </button>

        </form>

        <div class="bottom">
            Don't have an account?
            <a href="register.php">Register</a>
        </div>

    </div>

</div>

</body>
</html>