<?php
include("../includes/auth.php");
include("../includes/db.php");

// Check if ID is passed
if (!isset($_GET['id'])) {
    header("Location: view_rooms.php");
    exit();
}

$id = $_GET['id'];

// If confirm delete
if (isset($_POST['delete'])) {

    $query = "DELETE FROM rooms WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: view_rooms.php");
        exit();
    } else {
        $error = "Error deleting room!";
    }
}

// Fetch room details (for display)
$result = mysqli_query($conn, "SELECT * FROM rooms WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Room</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }

        .box {
            width: 40%;
            margin: 100px auto;
            background: white;
            padding: 25px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
        }

        h2 {
            color: red;
        }

        button {
            padding: 10px 15px;
            margin: 10px;
            border: none;
            border-radius: 5px;
        }

        .delete-btn {
            background: red;
            color: white;
        }

        .cancel-btn {
            background: gray;
            color: white;
        }

        a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Delete Room</h2>

    <p>Are you sure you want to delete this room?</p>

    <h3><?php echo $row['title']; ?></h3>

    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

    <form method="POST">
        <button type="submit" name="delete" class="delete-btn">Yes, Delete</button>
        <a href="view_rooms.php">
            <button type="button" class="cancel-btn">Cancel</button>
        </a>
    </form>
</div>

</body>
</html>