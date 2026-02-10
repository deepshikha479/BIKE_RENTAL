<?php
$servername = "127.0.0.1";   // safer than 'localhost'
$username = "root";          // default in XAMPP
$password = "";              // leave empty
$dbname = "bike_rental";     // must match your database name
$port = 3307;                // your MySQL port

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>