<?php
session_start();
include 'config.php';

$bike_id = $_POST['bike_id'];
$days = intval($_POST['days']);
$return_date = date('Y-m-d', strtotime("+$days days"));

// Get price
$result = $conn->query("SELECT price FROM bikes WHERE id=$bike_id");
$row = $result->fetch_assoc();
$total_cost = $days * $row['price'];

$_SESSION['cost'] = $total_cost;

// Insert rental
$sql = "INSERT INTO rentals (bike_id, days, cost, rental_date, return_date) 
        VALUES ('$bike_id', '$days', '$total_cost', CURDATE(), '$return_date')";

if ($conn->query($sql) === TRUE) {
    header("Location: payment.php");
} else {
    echo "Error: " . $conn->error;
}
?>