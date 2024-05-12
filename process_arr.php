<?php
// Start the session
session_start();

// Debug: Check all POST data
var_dump($_POST);

// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the form data
$arr_date = $_POST['arr_date'];
$arr_time = $_POST['arr_time'];
$location_id = $_POST['location_id'];
$journey_id = $_POST['journey_id'];

// Prepare the SQL query
if ($location_id != 0) {
    $sql = "INSERT INTO arrangement (arr_date, arr_time, location_id, journey_id) VALUES ('$arr_date', '$arr_time', '$location_id', '$journey_id')";
    if (mysqli_query($link, $sql)) {
        // Set session success message
        header("Location: arrangement.php?journey_id=$journey_id");
        exit;
    } else {
        // Set session error message
        echo "Error: " . mysqli_error($link);
    }
} else {
    header("Location: arrangement.php?journey_id=$journey_id");
    exit;
}
// Execute the query


// Close the connection
mysqli_close($link);
