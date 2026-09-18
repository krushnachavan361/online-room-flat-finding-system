<?php
include("../includes/owner_auth.php");
include("../includes/db.php");

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
        }

        .container {
            width: 400px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px gray;
            text-align: center;
        }

        h2 {
            margin-bottom: 15px;
        }

        .info {
            margin: 10px 0;
            font-size: 16px;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>User Profile</h2>

    <div class="info"><b>Name:</b> <?php echo $user['name']; ?></div>
    <div class="info"><b>Email:</b> <?php echo $user['email']; ?></div>
    <div class="info"><b>Phone:</b> <?php echo $user['phone']; ?></div>
    <div class="info"><b>Address:</b> <?php echo $user['address']; ?></div>

    <a class="btn" href="bookings.php">⬅ Back</a>

</div>

</body>
</html>