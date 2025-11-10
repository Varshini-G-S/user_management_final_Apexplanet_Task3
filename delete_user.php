<?php
include 'config.php';

if ($_SESSION['role_id'] != 1) die("Unauthorized!");

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id=$id");
header("Location: users_table.php");
?>
