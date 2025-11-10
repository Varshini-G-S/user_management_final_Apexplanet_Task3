<?php
include 'config.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];

    $profile_pic = null;
    if (!empty($_FILES['profile_pic']['name'])) {
        $targetDir = "uploads/";
        $profile_pic = $targetDir . basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $profile_pic);
    }

    $sql = "INSERT INTO users (username, email, password, role_id, profile_pic)
            VALUES ('$username', '$email', '$password', '$role_id', '$profile_pic')";

    if ($conn->query($sql)) {
        echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
<form method="POST" enctype="multipart/form-data">
    Username: <input type="text" name="username" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Role:
    <select name="role_id" required>
        <option value="1">Admin</option>
        <option value="2">User</option>
    </select><br><br>
    Profile Picture: <input type="file" name="profile_pic"><br><br>
    <button type="submit" name="register">Register</button>
</form>
</body>
</html>
