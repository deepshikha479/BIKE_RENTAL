<?php
$conn = new mysqli("localhost", "root", "", "bike_rental");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM bikes WHERE id=$id");
$row = $result->fetch_assoc();
?>

<form action="update_bike.php" method="POST">
  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
  <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
  <input type="text" name="type" value="<?php echo $row['type']; ?>"><br>
  <input type="number" name="price" value="<?php echo $row['price_per_day']; ?>"><br>
  <input type="submit" value="Update Bike">
</form>