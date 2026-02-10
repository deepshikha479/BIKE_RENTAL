
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bike_rental");

$card = $_POST['card'];
$cost = $_SESSION['cost'];

// For demo: any card number works
if(!empty($card)) {
    // Mark latest rental as paid
    $conn->query("UPDATE rentals SET paid=TRUE ORDER BY id DESC LIMIT 1");

    echo "<h1>Payment Successful!</h1>";
    echo "<p>Your bike rental is confirmed.</p>";
    echo "<p>Total Paid: $" . $cost . "</p>";
    echo "<a href='index.html'>Back to Home</a>";
} else {
    echo "Payment failed. Please try again.";
}
$conn->close();
?>