<?php
session_start();
if (!isset($_SESSION['cost'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment - Zombie's Bike Rental</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 50px; }
        .card { border: 1px solid #ccc; padding: 20px; display: inline-block; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Complete Your Rental</h2>
        <p>Total Amount Due: <strong>$<?php echo $_SESSION['cost']; ?></strong></p>
        <form action="comfirm.php" method="POST">
            <input type="text" name="card" placeholder="Dummy Card Number (16 digits)" required><br><br>
            <input type="submit" value="Pay Now" style="background: #f39c12; color: white; border: none; padding: 10px 20px; cursor: pointer;">
        </form>
    </div>
</body>
</html>