<?php
// Connect to your database. Replace with your connection details
$mysqli = new mysqli('localhost', 'root','12345678', 'travel');


// Get the form data
$split_id = $_POST['split_id'];
$address = $_POST['address'];
$journey_id = $_POST['journey_id'];
$split_amount = $_POST['split_amount'];
$pay_state = $_POST['pay_state'];

// Prepare an UPDATE statement
$stmt = $mysqli->prepare("UPDATE split_members SET split_amount = ?, pay_state = ? WHERE split_id = ? AND address = ?");

// Bind the variables to the prepared statement
$stmt->bind_param("iiis", $split_amount, $pay_state, $split_id, $address);

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