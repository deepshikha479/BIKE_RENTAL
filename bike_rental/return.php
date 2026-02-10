<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "bike_rental", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user_id exists
if (!isset($_SESSION['user_id'])) {
    die("Error: No user ID found in session. Please log in again.");
}

$user_id = intval($_SESSION['user_id']); 

// Get rental ID from URL
if (isset($_GET['rental_id'])) {
    $rental_id = intval($_GET['rental_id']);

    // Update rental record with return_date = NOW()
    $stmt = $conn->prepare("UPDATE rentals SET return_date = NOW() WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $rental_id, $user_id);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Bike returned successfully!</p>";
        echo "<a href='my_rentals.php'>Back to My Rentals</a>";
    } else {
        echo "<p style='color:red;'> Error: ".$stmt->error."</p>";
    }

    $stmt->close();
} else {
    echo "<p style='color:red;'>No rental ID provided.</p>";
}

$conn->close();
?>