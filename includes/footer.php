<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

.footer{
    background:#111827;
    color:white;
    margin-top:auto;
    padding-top:50px;
    font-family:'Poppins',sans-serif;
}

/* CONTAINER */
.footer-container{
    width:90%;
    margin:auto;

    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));

    gap:40px;
    padding-bottom:40px;
}

/* LOGO */
.footer-logo{
    color:#00ffcc;
    font-size:28px;
    font-weight:bold;
    margin-bottom:15px;
}

/* TEXT */
.footer-text{
    color:#d1d5db;
    line-height:1.8;
}

/* TITLES */
.footer-title{
    margin-bottom:15px;
    color:#00ffcc;
    font-size:20px;
}

/* LINKS */
.footer-links a{
    display:block;
    color:#d1d5db;
    text-decoration:none;
    margin-bottom:12px;
    transition:0.3s;
}

.footer-links a:hover{
    color:#00ffcc;
    transform:translateX(5px);
}

/* SOCIAL */
.social-icons{
    display:flex;
    gap:15px;
    margin-top:15px;
}

.social-icons a{
    width:40px;
    height:40px;

    display:flex;
    justify-content:center;
    align-items:center;

    background:#1f2937;
    color:white;

    border-radius:50%;
    text-decoration:none;

    transition:0.3s;
}

.social-icons a:hover{
    background:#00b894;
}

/* CONTACT */
.contact p{
    margin-bottom:12px;
    color:#d1d5db;
}

/* BOTTOM */
.footer-bottom{
    border-top:1px solid #374151;
    text-align:center;
    padding:20px;
    color:#9ca3af;
}

</style>

<!-- FOOTER -->
<div class="footer">

    <div class="footer-container">

        <!-- ABOUT -->
        <div>

            <div class="footer-logo">
                RoomRental
            </div>

            <div class="footer-text">

                Find premium rooms,
                PGs and rental homes easily.

            </div>

            <!-- SOCIAL -->
            <div class="social-icons">

                <a href="#">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a href="#">
                    <i class="fab fa-instagram"></i>
                </a>

                <a href="#">
                    <i class="fab fa-twitter"></i>
                </a>

            </div>

        </div>

        <!-- LINKS -->
        <div>

            <div class="footer-title">
                Quick Links
            </div>

            <div class="footer-links">

                <a href="/room-rental-system/index.php">
                    Home
                </a>



                <a href="/room-rental-system/user/login.php">
                    Login
                </a>

                <a href="/room-rental-system/user/register.php">
                    Register
                </a>

            </div>

        </div>

        <!-- CONTACT -->
        <div>

            <div class="footer-title">
                Contact
            </div>

            <div class="contact">

                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    Nagpur, Maharashtra
                </p>

                <p>
                    <i class="fas fa-phone"></i>
                    +91 9876543210
                </p>

                <p>
                    <i class="fas fa-envelope"></i>
                    support@roomrental.com
                </p>

            </div>

        </div>

    </div>

    <!-- BOTTOM -->
    <div class="footer-bottom">

        © 2026 Room Rental System |
        All Rights Reserved

    </div>

</div>