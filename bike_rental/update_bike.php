<?php
$conn = new mysqli("localhost", "root", "", "bike_rental");

$id    = $_POST['id'];
$name  = $_POST['name'];
$type  = $_POST['type'];
$price = $_POST['price'];

$stmt = $conn->prepare("UPDATE bikes SET name=?, type=?, price_per_day=? WHERE id=?");
$stmt->bind_param("ssdi", $name, $type, $price, $id);

if ($stmt->execute()) {
    echo "Bike updated successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>