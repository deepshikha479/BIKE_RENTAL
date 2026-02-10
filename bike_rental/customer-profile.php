<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "bike_rental");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$email = $_SESSION['email']; // store email in session at login
$result = $conn->query("SELECT * FROM users WHERE email='$email'");
$user = $result->fetch_assoc();

echo "<h1>My Profile</h1>";
echo "<img src='".htmlspecialchars($user['photo'])."' alt='Profile Photo' width='120'><br>";
echo "<p>Name: ".htmlspecialchars($user['name'])."</p>";
echo "<p>Email: ".htmlspecialchars($user['email'])."</p>";
echo "<p>Contact: ".htmlspecialchars($user['contact'])."</p>";
echo "<p>Address: ".htmlspecialchars($user['address'])."</p>";
echo "<p>Gender: ".htmlspecialchars($user['gender'])."</p>";
echo "<p>Document: <a href='".htmlspecialchars($user['document'])."' target='_blank'>View</a></p>";

$conn->close();
?>