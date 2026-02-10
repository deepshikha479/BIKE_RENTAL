<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bike_rental");

$username = $_POST['username'];
$password = md5($_POST['password']);

$result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
if ($result->num_rows > 0) {
    $_SESSION['user'] = $username;
    header("Location: admin.php");
} else {
    echo "Invalid login!";
}
$conn->close();
?>