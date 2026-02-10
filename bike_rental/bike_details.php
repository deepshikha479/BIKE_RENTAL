<?php
$conn = new mysqli("localhost", "root", "", "bike_rental", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM bikes WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $bike = $result->fetch_assoc();
    } else {
        $bike = null;
    }
} else {
    $bike = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bike Details - Zombie's Bike Rental</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .bike-details, .bike-options {
      max-width: 800px;
      margin: 40px auto;
      background: #ecf0f1;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
    }
    .bike-options {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }
    .bike-options .option {
      width: 30%;
      margin: 10px;
      background: #fff;
      padding: 10px;
      border-radius: 5px;
    }
    .bike-options img {
      width: 100%;
      border-radius: 5px;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      background: #f39c12;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Bike Details</h1>
  </header>

  <?php if ($bike): ?>
    <div class="bike-details">
      <img src="<?php echo htmlspecialchars($bike['photo']); ?>" alt="<?php echo htmlspecialchars($bike['name']); ?>">
      <h2><?php echo htmlspecialchars($bike['name']); ?></h2>
      <p>
        <?php 
        if (!empty($bike['description'])) {
            echo htmlspecialchars($bike['description']);
        } else {
            echo "No description available.";
        }
        ?>
      </p>
      <p><strong>Price: $<?php echo htmlspecialchars($bike['price']); ?>/day</strong></p>
      <a href="rent.html" class="btn">Rent This Bike</a>
    </div>
  <?php else: ?>
    <div class="bike-details">
      <h2>No bike selected</h2>
      <p>Please choose from our available bikes below:</p>
    </div>

    <!-- Show bike options -->
    <div class="bike-options">
      <?php
      $sql = "SELECT * FROM bikes LIMIT 3"; // show 3 options
      $options = $conn->query($sql);
      while ($row = $options->fetch_assoc()):
      ?>
        <div class="option">
          <a href="bike-details.php?id=<?php echo $row['id']; ?>">
            <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
          </a>
          <p>
            <?php 
            if (!empty($row['description'])) {
                echo htmlspecialchars($row['description']);
            } else {
                echo "No description available.";
            }
            ?>
          </p>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>

  <footer>
    <p>&copy; 2025 Zombie's Bike Rental</p>
  </footer>
</body>
</html>
<?php $conn->close(); ?>