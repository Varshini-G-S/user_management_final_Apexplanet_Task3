<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access!");
}

$role_id = $_SESSION['role_id'];

if ($role_id == 1) {
    $users = $conn->query("SELECT users.*, roles.role_name FROM users JOIN roles ON users.role_id = roles.id");
} else {
    $uid = $_SESSION['user_id'];
    $users = $conn->query("SELECT users.*, roles.role_name FROM users JOIN roles ON users.role_id = roles.id WHERE users.id=$uid");
}
?>

<!DOCTYPE html>
<html>
<head><title>Users Table</title></head>
<body>
<h2>Users Table</h2>
<a href="logout.php">Logout</a> | <a href="register.php">Add User</a><br><br>
<table border="1">
<tr>
    <th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Picture</th><th>Actions</th>
</tr>
<?php while($row = $users->fetch_assoc()) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['username'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['role_name'] ?></td>
    <td><img src="<?= $row['profile_pic'] ?>" width="50"></td>
    <td>
        <a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a> |
        <?php if ($role_id == 1) { ?>
            <a href="delete_user.php?id=<?= $row['id'] ?>">Delete</a>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</table>
</body>
</html>
