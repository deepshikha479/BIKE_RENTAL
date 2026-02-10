<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

//  Connect to database
$conn = new mysqli("localhost", "root", "", "bike_rental", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user_id exists in session BEFORE using it in SQL
if (!isset($_SESSION['user_id'])) {
    die("Error: No user ID found in session. Please log in again.");
}

$user_id = intval($_SESSION['user_id']); // sanitize

//  Now safe to run queries using $user_id
$sql = "SELECT rentals.id, bikes.name, bikes.type, rentals.days, rentals.cost, rentals.rental_date, rentals.return_date
        FROM rentals 
        JOIN bikes ON rentals.bike_id = bikes.id
        WHERE rentals.user_id = $user_id";

$result = $conn->query($sql);

//  Display results
echo "<h1>My Rentals</h1>";
echo "<table border='1' cellpadding='8'>
        <tr><th>Bike</th><th>Type</th><th>Days</th><th>Cost</th><th>Start</th><th>Return</th><th>Status</th></tr>";

while ($row = $result->fetch_assoc()) {
    $status = empty($row['return_date']) ? "Active" : "Returned";
    echo "<tr>
            <td>".htmlspecialchars($row['name'])."</td>
            <td>".htmlspecialchars($row['type'])."</td>
            <td>".htmlspecialchars($row['days'])."</td>
            <td>$".htmlspecialchars($row['cost'])."</td>
            <td>".htmlspecialchars($row['rental_date'])."</td>
            <td>".htmlspecialchars($row['return_date'])."</td>
            <td>$status</td>
          </tr>";
}
echo "</table>";

$conn->close();
?>