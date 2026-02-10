<?php
session_start();

// Protect page: only logged-in users can access
if(!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "bike_rental");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Handle Add Bike form submission BEFORE output
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_bike'])) {
    $name  = $_POST['name'];
    $type  = $_POST['type'];
    $price = $_POST['price'];

    // Save image to folder
    $photoPath = "uploads/bikes/" . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath);

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO bikes (name, type, price, is_available, photo) VALUES (?, ?, ?, TRUE, ?)");
    $stmt->bind_param("ssds", $name, $type, $price, $photoPath);
    $stmt->execute();
    $stmt->close();

    echo "<p style='color:green;'>Bike added successfully!</p>";
}


// Dashboard heading + Logout button
echo "<h1>Admin Dashboard</h1>";
echo "<a href='logout.php' style='
        display:inline-block;
        padding:8px 15px;
        background:#e74c3c;
        color:#fff;
        text-decoration:none;
        border-radius:5px;
        font-weight:bold;
        margin-bottom:20px;
      '>Logout</a><br><br>";

// Add Bike form with image upload
echo '<form method="POST" action="admin.php" enctype="multipart/form-data">
        <h3>Add New Bike</h3>
        <input type="text" name="name" placeholder="Bike Name" required>
        <input type="text" name="type" placeholder="Type" required>
        <input type="number" step="0.01" name="price" placeholder="Price per Day" required>
        
        <!-- Image upload -->
        <input type="file" name="photo" accept="image/*" required>
        
        <input type="submit" name="add_bike" value="Add Bike">
      </form><br><br>';

// Rentals table with Return button
$result = $conn->query("SELECT rentals.id, bikes.name, rentals.days, rentals.cost, rentals.rental_date, rentals.return_date 
                        FROM rentals 
                        JOIN bikes ON rentals.bike_id = bikes.id");

echo "<h2>Current Rentals</h2>";
echo "<table border='1' cellpadding='8'>
        <tr>
          <th>Bike</th><th>Days</th><th>Cost</th><th>Start</th><th>Return</th><th>Action</th>
        </tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>".$row['name']."</td>
            <td>".$row['days']."</td>
            <td>$".$row['cost']."</td>
            <td>".$row['rental_date']."</td>
            <td>".$row['return_date']."</td>
            <td>
              <form action='return.php' method='POST' style='display:inline;'>
                <input type='hidden' name='rental_id' value='".$row['id']."'>
                <input type='submit' value='Return'>
              </form>
            </td>
          </tr>";
}
echo "</table>";

$conn->close();
?>