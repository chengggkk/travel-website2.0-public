<?php

// Check if the delete button is clicked
if (isset($_GET['journey_id'])) {
    // Get the arr_id and travel_id from the URL
    $journey_id = $_GET['journey_id'];

    // Connect to the database

    $conn = new mysqli("localhost", "root", "12345678","travel");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform the delete operation
    $sql = "DELETE FROM journey WHERE journey_id = $journey_id ;";
    echo "SQL Query: " . $sql; // Add this line for debugging
        if ($conn->query($sql) === TRUE) {
        // Redirect to the header arrangement.php with the travel_id
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
        header("Location: index.php");
        exit;
    }

    $conn->close();
}
?>