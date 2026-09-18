<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

// Fetch all users
$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
        }

        h2 {
            text-align: center;
            padding: 20px;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background: #2c3e50;
            color: white;
        }

        .btn {
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }

        .edit { background: #3498db; }
        .delete { background: #e74c3c; }

        .back {
            display: block;
            text-align: center;
            margin: 20px;
        }
    </style>
</head>
<body>

<h2>Manage Users & Owners</h2>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Role</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['role']; ?></td>

    <td>
        <a class="btn edit" href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a class="btn delete" href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

<div class="back">
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>