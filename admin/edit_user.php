<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    mysqli_query($conn, "UPDATE users 
        SET name='$name', email='$email', phone='$phone', role='$role'
        WHERE id='$id'");

    header("Location: view_users.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            background: white;
            padding: 30px;
            width: 380px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #3498db;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
        }

        button:hover {
            background: #2980b9;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #333;
        }

        .back:hover {
            color: #3498db;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Edit User</h2>

    <form method="POST">
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

        <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>

        <select name="role">
            <option value="user" <?php if($user['role']=="user") echo "selected"; ?>>User</option>
            <option value="owner" <?php if($user['role']=="owner") echo "selected"; ?>>Owner</option>
        </select>

        <button type="submit" name="update">Update User</button>
    </form>

    <a class="back" href="view_users.php">⬅ Back to Manage Users</a>
</div>

</body>
</html>