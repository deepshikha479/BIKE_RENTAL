<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

// Use port 3307
$conn = new mysqli("localhost", "root", "", "bike_rental", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO support (user_id, subject, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $user_id, $subject, $message);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Support request submitted!</p>";
    } else {
        echo "<p style='color:red;'>Error: ".$stmt->error."</p>";
    }
    $stmt->close();
}
?>

<h1>Support</h1>
<form method="POST" action="support.php">
    <input type="text" name="subject" placeholder="Subject" required><br><br>
    <textarea name="message" placeholder="Your message" required></textarea><br><br>
    <button type="submit">Send</button>
</form>