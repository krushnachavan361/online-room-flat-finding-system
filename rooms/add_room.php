<?php
include("../includes/owner_auth.php");
include("../includes/db.php");

$user_id = $_SESSION['user_id'];

// ADD ROOM
if(isset($_POST['add_room'])){

    $title = $_POST['title'];
    $price = $_POST['price'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $room_type = $_POST['room_type'];
    $description = $_POST['description'];
    $map = $_POST['map'];
    $status = $_POST['status'];

    // AMENITIES
    $amenities = "";

    if(isset($_POST['amenities'])){
        $amenities = implode(", ", $_POST['amenities']);
    }

    // IMAGE UPLOAD
    $image = $_FILES['image']['name'];

    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp,
    "../assets/images/" . $image);

    // INSERT ROOM
    $query = "INSERT INTO rooms
    (
        user_id,
        room_title,
        price,
        city,
        area,
        room_type,
        description,
        amenities,
        map,
        status,
        image
    )

    VALUES
    (
        '$user_id',
        '$title',
        '$price',
        '$city',
        '$area',
        '$room_type',
        '$description',
        '$amenities',
        '$map',
        '$status',
        '$image'
    )";

    if(mysqli_query($conn,$query)){

        $success = "✅ Room Added Successfully";

    }else{

        $error = "❌ Failed To Add Room : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Ultimate Add Room</title>

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

/* CONTAINER */
.container{
    width:90%;
    max-width:1000px;
    margin:40px auto;
}

/* FORM BOX */
.form-box{
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

/* TITLE */
.title{
    text-align:center;
    margin-bottom:30px;
}

.title h1{
    color:#111827;
    margin-bottom:10px;
}

/* GRID */
.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

/* GROUP */
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
    box-shadow:0 0 8px rgba(0,184,148,0.3);
}

/* TEXTAREA */
textarea{
    resize:none;
    height:120px;
}

/* FULL */
.full{
    grid-column:1/3;
}

/* AMENITIES */
.amenities{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:10px;
}

.amenities label{
    font-weight:normal;
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

/* MESSAGE */
.success{
    background:#d4edda;
    color:#155724;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

.error{
    background:#f8d7da;
    color:#721c24;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

/* RESPONSIVE */
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
                🏠 Ultimate Add Room
            </h1>

            <p>
                Add premium rental rooms professionally
            </p>

        </div>

        <!-- SUCCESS -->
        <?php if(isset($success)) { ?>

            <div class="success">
                <?php echo $success; ?>
            </div>

        <?php } ?>

        <!-- ERROR -->
        <?php if(isset($error)) { ?>

            <div class="error">
                <?php echo $error; ?>
            </div>

        <?php } ?>

        <!-- FORM -->
        <form method="POST"
        enctype="multipart/form-data">

            <div class="form-grid">

                <!-- TITLE -->
                <div class="form-group">

                    <label>Room Title</label>

                    <input type="text"
                    name="title"
                    placeholder="Enter room title"
                    required>

                </div>

                <!-- PRICE -->
                <div class="form-group">

                    <label>Price</label>

                    <input type="number"
                    name="price"
                    placeholder="Enter room price"
                    required>

                </div>

                <!-- CITY -->
                <div class="form-group">

                    <label>Select City</label>

                    <select name="city"
                    id="city"
                    onchange="updateAreas()"
                    required>

                        <option value="">
                            Choose City
                        </option>

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

                    <label>Select Area</label>

                    <select name="area"
                    id="area"
                    required>

                        <option value="">
                            Choose Area
                        </option>

                    </select>

                </div>

                <!-- TYPE -->
                <div class="form-group">

                    <label>Room Type</label>

                    <select name="room_type"
                    required>

                        <option>PG</option>
                        <option>1BHK</option>
                        <option>2BHK</option>
                        <option>3BHK</option>

                    </select>

                </div>

                <!-- STATUS -->
                <div class="form-group">

                    <label>Availability</label>

                    <select name="status"
                    required>

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
                    name="image"
                    required>

                </div>

                <!-- MAP -->
                <div class="form-group">

                    <label>Google Maps Link</label>

                    <input type="text"
                    name="map"
                    placeholder="Paste Google Maps URL">

                </div>

                <!-- AMENITIES -->
                <div class="form-group full">

                    <label>Amenities</label>

                    <div class="amenities">

                        <label>
                            <input type="checkbox"
                            name="amenities[]"
                            value="WiFi"> WiFi
                        </label>

                        <label>
                            <input type="checkbox"
                            name="amenities[]"
                            value="Parking"> Parking
                        </label>

                        <label>
                            <input type="checkbox"
                            name="amenities[]"
                            value="AC"> AC
                        </label>

                        <label>
                            <input type="checkbox"
                            name="amenities[]"
                            value="Water"> Water
                        </label>

                        <label>
                            <input type="checkbox"
                            name="amenities[]"
                            value="Furniture"> Furniture
                        </label>

                        <label>
                            <input type="checkbox"
                            name="amenities[]"
                            value="Security"> Security
                        </label>

                    </div>

                </div>

                <!-- DESCRIPTION -->
                <div class="form-group full">

                    <label>Description</label>

                    <textarea
                    name="description"
                    placeholder="Enter room description"
                    required></textarea>

                </div>

                <!-- BUTTON -->
                <div class="form-group full">

                    <button type="submit"
                    name="add_room"
                    class="btn">

                        <i class="fas fa-plus-circle"></i>

                        Add Premium Room

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- AREA SCRIPT -->
<script>

function updateAreas(){

    let city = document.getElementById("city").value;

    let area = document.getElementById("area");

    area.innerHTML = '<option value=\"\">Choose Area</option>';

    let areas = {

        Nagpur:[
            "Dharampeth",
            "Sadar",
            "Manish Nagar",
            "Trimurti Nagar",
            "Wardha Road"
        ],

        Pune:[
            "Kothrud",
            "Baner",
            "Hinjewadi",
            "Wakad",
            "Hadapsar"
        ],

        Mumbai:[
            "Andheri",
            "Bandra",
            "Dadar",
            "Kurla",
            "Powai"
        ],

        Nashik:[
            "CIDCO",
            "College Road",
            "Panchavati"
        ],

        Aurangabad:[
            "CIDCO",
            "Garkheda",
            "Osmanpura"
        ],

        Kolhapur:[
            "Rajarampuri",
            "Shahupuri",
            "Tarabai Park"
        ]
    };

    areas[city].forEach(function(item){

        let option = document.createElement("option");

        option.value = item;

        option.text = item;

        area.appendChild(option);

    });
}

</script>

</body>
</html>