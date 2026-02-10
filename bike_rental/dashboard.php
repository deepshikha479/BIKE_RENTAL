<?php
session_start();
include 'config.php';

// Protect page
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'customer') {
    header("Location: login.html");
    exit();
}

// Fetch available bikes
$sql = "SELECT * FROM bikes WHERE is_available = TRUE";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#f4f6f9; }
        .sidebar { width:220px; background:#2c3e50; position:fixed; top:0; left:0; height:100%; color:white; padding-top:20px; }
        .sidebar a { display:block; color:white; padding:12px; text-decoration:none; }
        .sidebar a:hover { background:#34495e; }
        .header { margin-left:220px; padding:15px; background:#2980b9; color:white; }
        .content { margin-left:220px; padding:20px; }
        table { width:100%; border-collapse:collapse; margin-top:20px; background:white; }
        th, td { border:1px solid #ddd; padding:10px; text-align:center; }
        th { background:#3498db; color:white; }
        .logout { float:right; color:white; text-decoration:none; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 style="text-align:center;">🚴 Dashboard</h3>
        <a href="dashboard.php">Available Bikes</a>
        <a href="myrentals.php">My Rentals</a>
        <a href="profile.php">Profile</a>
        <a href="support.php">Support</a>
    </div>

    <!-- Header -->
    <div class="header">
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</span>
        <a class="logout" href="logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Available Bikes</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            echo "<table><tr><th>Name</th><th>Type</th><th>Price/Day</th><th>Action</th></tr>";
            while ($bike = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".htmlspecialchars($bike['name'])."</td>
                        <td>".htmlspecialchars($bike['type'])."</td>
                        <td>$".htmlspecialchars($bike['price'])."</td>
                        <td><a href='rent.php?bike_id=".$bike['id']."'>Rent</a></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No bikes available right now.</p>";
        }
        ?>
    </div>
</body>
</html>