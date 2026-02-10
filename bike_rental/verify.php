<?php
$conn = new mysqli("localhost", "root", "", "bike_rental");

$code = $_GET['code'];

$stmt = $conn->prepare("SELECT * FROM users WHERE verify_code=? AND is_verified=0");
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $conn->query("UPDATE users SET is_verified=1 WHERE verify_code='$code'");
    echo "Email verified successfully! You can now login.";
} else {
    echo "Invalid or expired verification link.";
}

$stmt->close();
$conn->close();
?>