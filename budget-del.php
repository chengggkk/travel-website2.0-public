<?php

// Check if the delete button is clicked
if (isset($_GET['budget_id']) && !empty($_GET['budget_id']) && isset($_GET['journey_id']) && !empty($_GET['journey_id'])) {
    // Get the arr_id and travel_id from the URL
    $budget_id = $_GET['budget_id'];
    $journey_id = $_GET['journey_id'];
    // Connect to the database

    $conn = new mysqli("localhost", "root", "12345678", "travel");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform the delete operation
    $sql = "DELETE FROM budget WHERE budget_id = $budget_id ;";
    echo "SQL Query: " . $sql; // Add this line for debugging
    if ($conn->query($sql) === TRUE) {
        // Redirect to the header arrangement.php with the travel_id
        header("Location: accounting.php?journey_id=$journey_id");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
