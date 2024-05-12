<?php
// Connect to your database. Replace with your connection details
$mysqli = new mysqli('localhost', 'root','12345678', 'travel');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the form data
$split_id = $_POST['split_id'];
$journey_id = $_POST['journey_id'];
$split_cate = $_POST['split_cate'];
$split_date = $_POST['split_date'];
$split_note = $_POST['split_note'];

// Prepare an UPDATE statement
$stmt = $mysqli->prepare("UPDATE split SET split_cate = ?, split_date = ?, split_note = ? WHERE split_id = ?");

// Bind the variables to the prepared statement
$stmt->bind_param("sssi", $split_cate, $split_date, $split_note, $split_id);

// Execute the prepared statement
$stmt->execute();

// Check if the update was successful
if ($stmt->affected_rows > 0) {
    echo "Record updated successfully";
    header("Location: accounting.php?journey_id=$journey_id");
} else {
    echo "Error updating record: " . $mysqli->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$mysqli->close();
?>