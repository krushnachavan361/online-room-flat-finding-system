<?php
session_start();
include("../includes/db.php");

// LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ROOM ID CHECK
if(!isset($_GET['id'])){
    header("Location: view_rooms.php");
    exit();
}

$room_id = $_GET['id'];

// FETCH ROOM
$query = "SELECT * FROM rooms
WHERE id='$room_id'
AND user_id='$user_id'";

$result = mysqli_query($conn,$query);

$room = mysqli_fetch_assoc($result);

if(!$room){
    die("Room Not Found");
}

// UPDATE ROOM
if(isset($_POST['update_room'])){

    $room_title = $_POST['room_title'];
    $price = $_POST['price'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $room_type = $_POST['room_type'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $map = $_POST['map'];

    // AMENITIES
    $amenities = "";

    if(isset($_POST['amenities'])){
        $amenities = implode(", ", $_POST['amenities']);
    }

    // IMAGE
    $image = $room['image'];

    if(!empty($_FILES['image']['name'])){

        $image = $_FILES['image']['name'];

        $tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp,
        "../assets/images/" . $image);
    }

    // UPDATE QUERY
    $update = "UPDATE rooms SET

    room_title='$room_title',
    price='$price',
    city='$city',
    area='$area',
    room_type='$room_type',
    description='$description',
    amenities='$amenities',
    map='$map',
    status='$status',
    image='$image'

    WHERE id='$room_id'";

    if(mysqli_query($conn,$update)){

        header("Location:view_rooms.php?updated=1");
        exit();

    }else{

        $error = "Failed To Update Room";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Room</title>

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- ICON -->
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

.container{
    width:90%;
    max-width:1000px;
    margin:40px auto;
}

.form-box{
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

.title{
    text-align:center;
    margin-bottom:30px;
}

.title h1{
    color:#111827;
    margin-bottom:10px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    padding:14px;
    border:1px solid #ccc;
    border-radius:12px;
    font-size:15px;
    outline:none;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{
    border-color:#00b894;
}

textarea{
    resize:none;
    height:120px;
}

.full{
    grid-column:1/3;
}

/* IMAGE */

.preview{
    width:100%;
    height:220px;
    border-radius:15px;
    overflow:hidden;
    margin-top:10px;
}

.preview img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* AMENITIES */

.amenities{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:10px;
}

/* BUTTON */

.btn{
    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    background:#00b894;
    color:white;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#00997a;
}

/* ERROR */

.error{
    background:#f8d7da;
    color:#721c24;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

@media(max-width:768px){

    .form-grid{
        grid-template-columns:1fr;
    }

    .full{
        grid-column:1/2;
    }

    .amenities{
        grid-template-columns:1fr;
    }
}

</style>
</head>

<body>

<div class="container">

    <div class="form-box">

        <!-- TITLE -->

        <div class="title">

            <h1>
                ✏ Edit Room
            </h1>

            <p>
                Update your room details professionally
            </p>

        </div>

        <!-- ERROR -->

        <?php if(isset($error)){ ?>

        <div class="error">

            <?php echo $error; ?>

        </div>

        <?php } ?>

        <!-- FORM -->

        <form method="POST"
        enctype="multipart/form-data">

            <div class="form-grid">

                <!-- ROOM TITLE -->

                <div class="form-group">

                    <label>Room Title</label>

                    <input type="text"
                    name="room_title"
                    value="<?php echo $room['room_title']; ?>"
                    required>

                </div>

                <!-- PRICE -->

                <div class="form-group">

                    <label>Price</label>

                    <input type="number"
                    name="price"
                    value="<?php echo $room['price']; ?>"
                    required>

                </div>

                <!-- CITY -->

                <div class="form-group">

                    <label>City</label>

                    <select name="city" required>

                        <option><?php echo $room['city']; ?></option>

                        <option>Nagpur</option>
                        <option>Pune</option>
                        <option>Mumbai</option>
                        <option>Nashik</option>
                        <option>Aurangabad</option>
                        <option>Kolhapur</option>

                    </select>

                </div>

                <!-- AREA -->

                <div class="form-group">

                    <label>Area</label>

                    <input type="text"
                    name="area"
                    value="<?php echo $room['area']; ?>"
                    required>

                </div>

                <!-- ROOM TYPE -->

                <div class="form-group">

                    <label>Room Type</label>

                    <select name="room_type" required>

                        <option>
                            <?php echo $room['room_type']; ?>
                        </option>

                        <option>PG</option>
                        <option>1BHK</option>
                        <option>2BHK</option>
                        <option>3BHK</option>

                    </select>

                </div>

                <!-- STATUS -->

                <div class="form-group">

                    <label>Status</label>

                    <select name="status" required>

                        <option value="<?php echo $room['status']; ?>">

                            <?php echo ucfirst($room['status']); ?>

                        </option>

                        <option value="available">
                            Available
                        </option>

                        <option value="occupied">
                            Occupied
                        </option>

                    </select>

                </div>

                <!-- IMAGE -->

                <div class="form-group">

                    <label>Room Image</label>

                    <input type="file"
                    name="image">

                    <div class="preview">

                        <img src="../assets/images/<?php echo $room['image']; ?>">

                    </div>

                </div>

                <!-- MAP -->

                <div class="form-group">

                    <label>Google Map Link</label>

                    <input type="text"
                    name="map"
                    value="<?php echo $room['map']; ?>">

                </div>

                <!-- AMENITIES -->

                <div class="form-group full">

                    <label>Amenities</label>

                    <div class="amenities">

                        <?php

                        $savedAmenities = explode(",", $room['amenities']);

                        $allAmenities = [
                            "WiFi",
                            "Parking",
                            "AC",
                            "Water",
                            "Furniture",
                            "Security"
                        ];

                        foreach($allAmenities as $item){

                        ?>

                        <label>

                            <input type="checkbox"
                            name="amenities[]"
                            value="<?php echo $item; ?>"

                            <?php

                            if(in_array($item,$savedAmenities)){
                                echo "checked";
                            }

                            ?>>

                            <?php echo $item; ?>

                        </label>

                        <?php } ?>

                    </div>

                </div>

                <!-- DESCRIPTION -->

                <div class="form-group full">

                    <label>Description</label>

                    <textarea
                    name="description"
                    required><?php echo $room['description']; ?></textarea>

                </div>

                <!-- BUTTON -->

                <div class="form-group full">

                    <button type="submit"
                    name="update_room"
                    class="btn">

                        <i class="fas fa-save"></i>

                        Update Room

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

</body>
</html>