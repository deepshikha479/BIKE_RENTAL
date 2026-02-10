<?php
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Collect form data
$name     = $_POST['name'] ?? '';
$email    = $_POST['email'] ?? '';
$contact  = $_POST['contact'] ?? '';
$address  = $_POST['address'] ?? '';
$gender   = $_POST['gender'] ?? '';
$password = $_POST['password'] ?? '';

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Handle file uploads
$document = "uploads/docs/" . basename($_FILES["document"]["name"]);
$photo    = "uploads/photos/" . basename($_FILES["photo"]["name"]);

move_uploaded_file($_FILES["document"]["tmp_name"], $document);
move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);

// Insert into database
$stmt = $conn->prepare("INSERT INTO users (name, email, contact, address, gender, document, photo, password, role) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'customer')");
if (!$stmt) {
    die(" Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssssss", $name, $email, $contact, $address, $gender, $document, $photo, $hashedPassword);

if ($stmt->execute()) {
    // Redirect to login page
    header("Location: login.php");
    exit();
} else {
    echo " Error inserting data: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>