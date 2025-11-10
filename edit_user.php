<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) die("Unauthorized!");

$id = $_GET['id'];

if ($_SESSION['role_id'] != 1 && $_SESSION['user_id'] != $id) {
    die("Unauthorized!");
}

$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];

    $profile_pic = $user['profile_pic'];
    if (!empty($_FILES['profile_pic']['name'])) {
        $targetDir = "uploads/";
        $profile_pic = $targetDir . basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $profile_pic);
    }

    $conn->query("UPDATE users SET username='$username', email='$email', role_id='$role_id', profile_pic='$profile_pic' WHERE id=$id");
    header("Location: users_table.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit User</title></head>
<body>
<h2>Edit User</h2>
<form method="POST" enctype="multipart/form-data">
    Username: <input type="text" name="username" value="<?= $user['username'] ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= $user['email'] ?>" required><br><br>
    Role:
    <select name="role_id">
        <option value="1" <?= $user['role_id']==1?'selected':'' ?>>Admin</option>
        <option value="2" <?= $user['role_id']==2?'selected':'' ?>>User</option>
    </select><br><br>
    Profile Picture: <input type="file" name="profile_pic"><br><br>
    <button type="submit" name="update">Update</button>
</form>
</body>
</html>
