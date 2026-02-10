<?php
session_start();
// This file contains $servername = "127.0.0.1" and $port = 3307
include 'config.php'; 

// 1. Get bike_id from the URL link
$bike_id = isset($_GET['bike_id']) ? $_GET['bike_id'] : null;

if (!$bike_id) {
    die("Error: No bike selected. Please go back to the dashboard.");
}

// 2. Fetch the bike details to show a simple rent form
$result = $conn->query("SELECT * FROM bikes WHERE id = $bike_id");
$bike = $result->fetch_assoc();

if (!$bike) {
    die("Bike not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rent <?php echo $bike['name']; ?></title>
    <style>
        body { font-family: Arial; text-align: center; padding: 50px; }
        .box { border: 1px solid #ccc; padding: 20px; display: inline-block; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Rent: <?php echo htmlspecialchars($bike['name']); ?></h2>
        <p>Price per day: $<?php echo htmlspecialchars($bike['price']); ?></p>
        
        <form action="process_rent.php" method="POST">
            <input type="hidden" name="bike_id" value="<?php echo $bike['id']; ?>">
            <label>How many days?</label><br>
            <input type="number" name="days" value="1" min="1" required><br><br>
            <input type="submit" value="Calculate Price & Pay" style="background: #27ae60; color: white; padding: 10px; border: none; cursor: pointer;">
        </form>
    </div>
</body>
</html>