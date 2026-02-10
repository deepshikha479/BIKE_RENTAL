<div class="sidebar">
  <h2>Bike Rental System</h2>
  <ul>
    <!-- Common Links -->
    <li><a href="dashboard.php"> Dashboard</a></li>
    <li><a href="profile.php"> My Profile</a></li>
    <li><a href="rentals.php"> My Rentals</a></li>
    <li><a href="return.php"> Return Bike</a></li>
    
    <!-- Admin Links -->
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
      <li><a href="manage_bikes.php"> Manage Bikes</a></li>
      <li><a href="manage_users.php"> Manage Users</a></li>
      <li><a href="reports.php"> Reports</a></li>
    <?php } ?>
    
    <!-- Logout -->
    <li><a href="logout.php">Logout</a></li>
  </ul>
</div>

<!-- Optional CSS for styling -->
<style>
.sidebar {
  width: 220px;
  background: #2c3e50;
  color: #fff;
  padding: 15px;
  height: 100vh;
}
.sidebar h2 {
  text-align: center;
  margin-bottom: 20px;
}
.sidebar ul {
  list-style: none;
  padding: 0;
}
.sidebar ul li {
  margin: 12px 0;
}
.sidebar ul li a {
  color: #fff;
  text-decoration: none;
  display: block;
  padding: 8px;
  border-radius: 4px;
}
.sidebar ul li a:hover {
  background: #34495e;
}
</style>