<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Room Rental System</title>

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

/* NAVBAR */
.navbar{
    width:100%;
    position:absolute;
    top:0;
    left:0;
    padding:20px 60px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    z-index:100;
}

.logo{
    color:white;
    font-size:28px;
    font-weight:bold;
}

.nav-links a{
    color:white;
    text-decoration:none;
    margin-left:25px;
    font-size:16px;
    transition:0.3s;
}

.nav-links a:hover{
    color:#00ffcc;
}

/* HERO */
.hero{
    height:100vh;

    background:
    linear-gradient(rgba(0,0,0,0.25),rgba(0,0,0,0.25)),
    url('assets/images/bgr.jpg');

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    display:flex;
    justify-content:center;
    align-items:center;

    text-align:center;
    color:white;
}

/* HERO CONTENT */
.hero-content{
    max-width:1000px;
}

.hero-content h1{
    font-size:60px;
    margin-bottom:20px;
}

.hero-content p{
    font-size:20px;
    margin-bottom:30px;
    line-height:1.8;
}

/* BUTTONS */
.buttons{
    display:flex;
    justify-content:center;
    gap:20px;
    flex-wrap:wrap;
}

.btn{
    padding:14px 28px;
    border-radius:12px;
    text-decoration:none;
    font-size:16px;
    transition:0.3s;
}

/* PRIMARY */
.primary-btn{
    background:#00b894;
    color:white;
}

.primary-btn:hover{
    background:#00997a;
}

/* SECONDARY */
.secondary-btn{
    background:white;
    color:#111827;
}

.secondary-btn:hover{
    background:#e5e7eb;
}

/* FEATURES */
.features{
    width:90%;
    margin:70px auto;

    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

/* FEATURE CARD */
.feature-card{
    background:white;
    padding:30px;
    border-radius:15px;
    text-align:center;

    box-shadow:0 5px 15px rgba(0,0,0,0.1);

    transition:0.3s;
}

.feature-card:hover{
    transform:translateY(-8px);
}

.feature-card i{
    font-size:40px;
    color:#00b894;
    margin-bottom:20px;
}

.feature-card h3{
    margin-bottom:15px;
    color:#111827;
}

.feature-card p{
    color:#555;
    line-height:1.7;
}

/* FOOTER */
.footer{
    background:#111827;
    color:white;
    text-align:center;
    padding:20px;
    margin-top:50px;
}

</style>

</head>

<body>
     <?php include("includes/header.php"); ?>



    <!-- LINKS -->
    <div class="nav-links">

        <a href="index.php">Home</a>

        

        <?php if(isset($_SESSION['user_id'])) { ?>

            <a href="user/dashboard.php">
                Dashboard
            </a>

            <a href="logout.php">
                Logout
            </a>

        <?php } else { ?>

            <a href="user/login.php">
                Login
            </a>

            <a href="user/register.php">
                Register
            </a>

        <?php } ?>

    </div>

</div>

<!-- HERO -->
<div class="hero">

    <div class="hero-content">

        <h1>
            Find Your Perfect Room
        </h1>

        <p>
            Discover affordable PGs, 1BHK, 2BHK and rental rooms easily with premium experience.
        </p>

        <!-- BUTTONS -->
        <div class="buttons">
<a href="user/login.php"
class="btn primary-btn">

    <i class="fas fa-home"></i>

    Explore Rooms

</a>
            <a href="user/register.php"
            class="btn secondary-btn">

                <i class="fas fa-user-plus"></i>

                Get Started

            </a>

        </div>

    </div>

</div>

<!-- FEATURES -->
<div class="features">

    <!-- CARD -->
    <div class="feature-card">

        <i class="fas fa-search-location"></i>

        <h3>Easy Search</h3>

        <p>
            Search rooms by city, price and room type quickly.
        </p>

    </div>

    <!-- CARD -->
    <div class="feature-card">

        <i class="fas fa-comments"></i>

        <h3>Direct Messaging</h3>

        <p>
            Chat directly with owners before booking rooms.
        </p>

    </div>

    <!-- CARD -->
    <div class="feature-card">

        <i class="fas fa-shield-alt"></i>

        <h3>Safe Booking</h3>

        <p>
            Secure room booking system with owner approval.
        </p>

    </div>

    <!-- CARD -->
    <div class="feature-card">

        <i class="fas fa-building"></i>

        <h3>Multiple Room Types</h3>

        <p>
            Find PG, 1BHK, 2BHK and other rental options.
        </p>

    </div>

</div>

<?php include("includes/footer.php"); ?>

</body>
</html>