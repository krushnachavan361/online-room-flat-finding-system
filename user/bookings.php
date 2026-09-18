<?php
include("../includes/user_auth.php");
include("../includes/db.php");

$user_id = $_SESSION['user_id'];

$query = "SELECT b.*, r.title 
          FROM bookings b
          JOIN rooms r ON b.room_id = r.id
          WHERE b.user_id='$user_id'
          ORDER BY b.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; }

        h2 { text-align: center; }

        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .pending { color: orange; }
        .accepted { color: green; }
        .rejected { color: red; }
    </style>
</head>
<body>

<h2>My Bookings</h2>

<table>
<tr>
    <th>Room</th>
    <th>Status</th>
    <th>Notice</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['title']; ?></td>

    <td class="<?php echo $row['status']; ?>">
        <?php echo ucfirst($row['status']); ?>
    </td>

    <td>
        <?php if($row['status'] == 'pending') { ?>
            ⏳ Waiting for owner approval
        <?php } elseif($row['status'] == 'accepted') { ?>
            ✅ Your booking is approved!
        <?php } else { ?>
            ❌ Booking rejected by owner
        <?php } ?>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>