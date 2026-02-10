<?php
$conn = new mysqli("localhost", "root", "", "bike_rental");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$type = $_POST['type'];
$price = $_POST['price'];

// Insert new bike
$sql = "INSERT INTO bikes (name, type, price, is_available, photo) 
        VALUES ('$name', '$type', '$price', TRUE, 'uploads/bikes/default.jpg')";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>Bike added successfully!</p>";
} else {
    echo "Error: " . $conn->error;
}

// Show all bikes with images
$result_bikes = $conn->query("SELECT * FROM bikes");

echo "<h2>All Bikes</h2>";
echo "<table border='1' cellpadding='8'>
        <tr>
          <th>Image</th><th>Name</th><th>Type</th><th>Price/Day</th><th>Status</th>
        </tr>";

while($bike = $result_bikes->fetch_assoc()) {
    echo "<tr>
            <td><img src='".htmlspecialchars($bike['photo'])."' alt='Bike Image' width='100'></td>
            <td>".htmlspecialchars($bike['name'])."</td>
            <td>".htmlspecialchars($bike['type'])."</td>
            <td>$".htmlspecialchars($bike['price'])."</td>
            <td>".($bike['is_available'] ? "Available" : "Rented")."</td>
          </tr>";
}
echo "</table><br><br>";

$conn->close();
?>