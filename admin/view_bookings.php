<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

$result = mysqli_query($conn, "SELECT b.*, u.name, r.title 
FROM bookings b
JOIN users u ON b.user_id=u.id
JOIN rooms r ON b.room_id=r.id");
?>

<h2>All Bookings</h2>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<p>
Room: <?php echo $row['title']; ?> |
User: <?php echo $row['name']; ?> |
Status: <?php echo $row['status']; ?>
</p>
<?php } ?>