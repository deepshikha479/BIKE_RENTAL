<?php
$conn = new mysqli("localhost", "root", "", "bike_rental");

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM bikes WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo " Bike deleted successfully!";
} else {
    echo " Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>