<?php
// process_login.php

session_start();

// Get the form data
$address = $_POST['address'];
$password = $_POST['password'];

// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare the SQL query
$sql = "SELECT DISTINCT * FROM account WHERE address='$address'";

$getmaxjourneyid = "SELECT MAX(journey_id) as max FROM journey_members WHERE address='$address'";
$journeyresult = mysqli_query($link, $getmaxjourneyid);
$jour_row = mysqli_fetch_assoc($journeyresult);
$journey_id = $jour_row['max'];

// Execute the query
$result = mysqli_query($link, $sql);

// Check the result
if ($row = mysqli_fetch_assoc($result)) {
    // Address found, check password
    if ($row['password'] == $password) {
        // Login successful
        $_SESSION['address'] = $address;
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];
        header('Location: index.php'); // Redirect to index.php
        exit;
    } else {
        // Wrong password
        $_SESSION['message'] = "帳號或密碼錯誤";
        $_SESSION['msg_type'] = "danger";
        header('Location: login.php'); // Redirect to login.php
        exit;
    }
} else {
    // Address not found
    $_SESSION['message'] = "無此帳號";
    $_SESSION['msg_type'] = "danger";
    header('Location: login.php'); // Redirect to login.php
    exit;
}




// Close the connection
mysqli_close($link);
?>