<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
}

/* HEADER */

.header{
    width:100%;
    position:sticky;
    top:0;
    z-index:1000;

    background:rgba(17,24,39,0.9);
    backdrop-filter:blur(12px);

    box-shadow:0 5px 20px rgba(0,0,0,0.2);
}

/* NAVBAR */

.navbar{
    width:92%;
    margin:auto;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:16px 0;
}

/* LOGO */

.logo{
    font-size:30px;
    font-weight:700;

    background:linear-gradient(135deg,#00ffcc,#00b894);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* LINKS */

.nav-links{
    display:flex;
    align-items:center;
    gap:22px;
}

.nav-links a{
    color:white;
    text-decoration:none;
    font-size:15px;
    font-weight:500;
    position:relative;
    transition:0.3s;
}

/* UNDERLINE EFFECT */

.nav-links a::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-6px;
    width:0%;
    height:2px;
    background:#00ffcc;
    transition:0.3s;
}

.nav-links a:hover::after{
    width:100%;
}

.nav-links a:hover{
    color:#00ffcc;
}

/* USER MENU */

.user-menu{
    position:relative;
}

.user-btn{
    background:linear-gradient(135deg,#00b894,#00cec9);
    color:white;

    padding:11px 16px;

    border-radius:12px;

    cursor:pointer;

    display:flex;
    align-items:center;
    gap:8px;

    font-weight:500;

    transition:0.3s;
}

.user-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
}

/* DROPDOWN */

.dropdown{
    position:absolute;
    top:58px;
    right:0;

    width:220px;

    background:white;

    border-radius:16px;

    overflow:hidden;

    box-shadow:0 10px 30px rgba(0,0,0,0.15);

    display:none;
}

.dropdown a{
    display:flex;
    align-items:center;
    gap:10px;

    padding:14px 18px;

    color:#111827;
    text-decoration:none;

    transition:0.3s;
}

.dropdown a:hover{
    background:#f4f7fb;
    color:#00b894;
}

.user-menu:hover .dropdown{
    display:block;
}

/* LOGIN BUTTON */

.auth-btn{
    background:linear-gradient(135deg,#667eea,#764ba2);
    padding:10px 18px;
    border-radius:10px;
    transition:0.3s;
}

.auth-btn:hover{
    transform:translateY(-2px);
}

/* MOBILE */

.menu-btn{
    display:none;
    color:white;
    font-size:26px;
    cursor:pointer;
}

@media(max-width:768px){

    .menu-btn{
        display:block;
    }

    .nav-links{
        position:absolute;
        top:75px;
        left:0;

        width:100%;

        background:#111827;

        flex-direction:column;
        align-items:flex-start;

        padding:20px;

        display:none;
    }

    .nav-links.active{
        display:flex;
    }

    .dropdown{
        position:static;
        width:100%;
        margin-top:10px;
    }
}

</style>

<!-- HEADER -->

<div class="header">

    <div class="navbar">

        <!-- LOGO -->

        <div class="logo">
            🏠 RoomRental
        </div>

        <!-- MOBILE -->

        <div class="menu-btn" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>

        <!-- NAV LINKS -->

        <div class="nav-links" id="navLinks">

            <a href="/room-rental-system/index.php">
                Home
            </a>
            




            <?php if(isset($_SESSION['user_id'])) { ?>

            <!-- USER MENU -->

            <div class="user-menu">

                <div class="user-btn">

                    <i class="fas fa-user-circle"></i>

                    <?php echo $_SESSION['name'] ?? 'Account'; ?>

                </div>

                <!-- DROPDOWN -->

                <div class="dropdown">

                    <?php if($_SESSION['role'] == 'admin'){ ?>

                    <a href="/room-rental-system/admin/dashboard.php">
                        <i class="fas fa-user-shield"></i>
                        Admin Dashboard
                    </a>

                    <?php } elseif($_SESSION['role'] == 'owner'){ ?>

                    <a href="/room-rental-system/owner/dashboard.php">
                        <i class="fas fa-building"></i>
                        Owner Dashboard
                    </a>

                    <a href="/room-rental-system/owner/inbox.php">
                        <i class="fas fa-envelope"></i>
                        Inbox
                    </a>

                    <?php } else { ?>

                    <a href="/room-rental-system/user/dashboard.php">
                        <i class="fas fa-user"></i>
                        User Dashboard
                    </a>

                    <a href="/room-rental-system/user/my_bookings.php">
                        <i class="fas fa-calendar-check"></i>
                        My Bookings
                    </a>

                    <?php } ?>

                    <a href="/room-rental-system/logout.php">

                        <i class="fas fa-sign-out-alt"></i>

                        Logout

                    </a>

                </div>

            </div>

            <?php } else { ?>

                <a class="auth-btn" href="/room-rental-system/user/login.php">
                    Login
                </a>

                <a class="auth-btn" href="/room-rental-system/user/register.php">
                    Register
                </a>

            <?php } ?>

        </div>

    </div>

</div>

<!-- SCRIPT -->

<script>

function toggleMenu(){

    document.getElementById('navLinks')
    .classList.toggle('active');
}

</script>