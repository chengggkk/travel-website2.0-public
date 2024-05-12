<?php
// Check if form is submitted
// Get the form data
$split_id = $_GET['split_id'];
$address = $_GET['address'];
$journey_id = $_GET['journey_id'];

// Create a connection to the database
$conn = new mysqli('localhost', 'root', '12345678', 'travel');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE split_members SET pay_state=? WHERE split_id=? AND address=?");

// Determine the value of pay_state based on the current state
// If pay_state is 0, update it to 1 (indicating payment made), otherwise update it to 0 (indicating payment not made)
$pay_state = ($row['pay_state'] == 0) ? 1 : 0;

// Bind the parameters
$stmt->bind_param("iis", $pay_state, $split_id, $address);

// Execute the statement
if ($stmt->execute()) {
    echo "Record updated successfully";
    header("Location: accounting.php?journey_id=$journey_id");
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
