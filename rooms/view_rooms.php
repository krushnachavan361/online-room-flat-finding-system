<?php
session_start();
include("../includes/db.php");

// FILTERS
$city = isset($_GET['city']) ? $_GET['city'] : '';
$room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// QUERY
$query = "SELECT * FROM rooms WHERE status='available'";

// FILTER CITY
if($city != ''){
    $query .= " AND city='$city'";
}

// FILTER ROOM TYPE
if($room_type != ''){
    $query .= " AND room_type='$room_type'";
}

// SORT
if($sort == 'low'){
    $query .= " ORDER BY price ASC";
}
elseif($sort == 'high'){
    $query .= " ORDER BY price DESC";
}
else{
    $query .= " ORDER BY id DESC";
}

// FETCH ROOMS
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>View Rooms</title>

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

/* HEADER */

.header{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    padding:30px;
    text-align:center;
}

.header h1{
    font-size:36px;
    margin-bottom:10px;
}

/* FILTER */

.filter-box{
    width:90%;
    margin:30px auto;
    background:white;
    padding:20px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

.filter-form{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

.filter-form select,
.filter-form button{
    padding:14px;
    border-radius:12px;
    border:1px solid #ccc;
    font-size:15px;
}

.filter-form button{
    background:#00b894;
    color:white;
    border:none;
    cursor:pointer;
    transition:0.3s;
}

.filter-form button:hover{
    background:#00997a;
}

/* ROOM GRID */

.rooms{
    width:90%;
    margin:30px auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:25px;
}

/* ROOM CARD */

.room-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}

.room-card:hover{
    transform:translateY(-5px);
}

/* IMAGE */

.room-image{
    width:100%;
    height:240px;
    overflow:hidden;
}

.room-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* CONTENT */

.room-content{
    padding:20px;
}

/* TITLE */

.room-title{
    font-size:24px;
    font-weight:bold;
    color:#111827;
    margin-bottom:10px;
}

/* PRICE */

.price{
    color:#00b894;
    font-size:24px;
    font-weight:bold;
    margin-bottom:15px;
}

/* INFO */

.info{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:15px;
}

.info span{
    background:#f4f6f9;
    padding:8px 14px;
    border-radius:30px;
    font-size:14px;
}

/* DESCRIPTION */

.description{
    color:#555;
    margin-bottom:20px;
    line-height:1.6;
}

/* BUTTON */

.btn{
    display:block;
    text-align:center;
    background:#667eea;
    color:white;
    text-decoration:none;
    padding:14px;
    border-radius:12px;
    transition:0.3s;
    font-weight:600;
}

.btn:hover{
    background:#5a67d8;
}

/* NO ROOM */

.no-room{
    width:90%;
    margin:50px auto;
    background:white;
    padding:40px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

.no-room h2{
    color:#555;
}

</style>
</head>

<body>

<!-- HEADER -->

<div class="header">

    <h1>🏠 Explore Premium Rooms</h1>

    <p>
        Find your perfect rental room easily
    </p>

</div>

<!-- FILTER -->

<div class="filter-box">

    <form method="GET" class="filter-form">

        <!-- CITY -->

        <select name="city">

            <option value="">
                Select City
            </option>

            <option value="Nagpur">Nagpur</option>

            <option value="Pune">Pune</option>

            <option value="Mumbai">Mumbai</option>

            <option value="Nashik">Nashik</option>

            <option value="Aurangabad">Aurangabad</option>

            <option value="Kolhapur">Kolhapur</option>

        </select>

        <!-- ROOM TYPE -->

        <select name="room_type">

            <option value="">
                Room Type
            </option>

            <option value="PG">PG</option>

            <option value="1BHK">1BHK</option>

            <option value="2BHK">2BHK</option>

            <option value="3BHK">3BHK</option>

        </select>

        <!-- SORT -->

        <select name="sort">

            <option value="">
                Sort Price
            </option>

            <option value="low">
                Low To High
            </option>

            <option value="high">
                High To Low
            </option>

        </select>

        <!-- BUTTON -->

        <button type="submit">

            <i class="fas fa-search"></i>

            Search Rooms

        </button>

    </form>

</div>

<!-- ROOMS -->

<div class="rooms">

<?php if(mysqli_num_rows($result) > 0) { ?>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

    <div class="room-card">

        <!-- IMAGE -->

        <div class="room-image">

            <img src="../assets/images/<?php echo $row['image']; ?>">

        </div>

        <!-- CONTENT -->

        <div class="room-content">

            <!-- TITLE -->

            <div class="room-title">

                <?php echo $row['room_title']; ?>

            </div>

            <!-- PRICE -->

            <div class="price">

                ₹<?php echo $row['price']; ?>

            </div>

            <!-- INFO -->

            <div class="info">

                <span>
                    📍 <?php echo $row['city']; ?>
                </span>

                <span>
                    🏠 <?php echo $row['room_type']; ?>
                </span>

            </div>

            <!-- DESCRIPTION -->

            <div class="description">

                <?php

                echo substr($row['description'],0,80);

                ?>...

            </div>

            <!-- BUTTON -->

            <a href="room_details.php?id=<?php echo $row['id']; ?>"
            class="btn">

                View Details

            </a>

        </div>

    </div>

<?php } ?>

<?php } else { ?>

<div class="no-room">

    <h2>
        ❌ No Rooms Found
    </h2>

</div>

<?php } ?>

</div>

</body>
</html>