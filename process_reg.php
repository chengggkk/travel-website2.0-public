<?php
// process_reg.php

// Get the form data
$address = $_POST['address'];
$password = $_POST['password'];
$username = $_POST['name'];
$email = $_POST['email'];

// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare the SQL query
$sql = "INSERT INTO account (address, password, username, email) VALUES ('$address', '$password', '$username', '$email')";

// Execute the query
if (mysqli_query($link, $sql)) {
    header('Location: login.php'); // Redirect to login.php
    exit;
} else {
    session_start();
    $_SESSION['message'] = "已有帳號";
    header('Location: register.php'); // Redirect to register.php
    exit;
}

// Close the connection
mysqli_close($link);
?>