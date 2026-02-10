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

// Fetch all bikes
$sql = "SELECT * FROM bikes";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Available Bikes</title>
    <link rel="stylesheet" href="style.css"> <!-- optional CSS -->
</head>
<body>
<?php include 'sidebar.php'; ?> <!-- navigation -->

<div class="content">
    <h1>Available Bikes</h1>
    <table border="1" cellpadding="8">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Type</th>
            <th>Cost/Day</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" width="120">
                    <?php else: ?>
                        No image
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['type']); ?></td>
                <td>$<?php echo htmlspecialchars($row['cost_per_day']); ?></td>
                <td>
                    <a href="bike-details.php?id=<?php echo $row['id']; ?>">view details</a>
                    
                    <form method="POST" action="rent.php">
                        <input type="hidden" name="bike_id" value="<?php echo $row['id']; ?>">
                        <label>Days:</label>
                        <input type="number" name="days" min="1" required>
                        <button type="submit">Rent</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
<?php
$conn->close();
?>