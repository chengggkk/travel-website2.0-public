<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $journey_id = $_POST['journey_id'];
    $journey_name = $_POST['journey_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Create a connection to the database
    $conn = new mysqli('localhost', 'root', '12345678', 'travel');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE journey SET journey_name=?, start_date=?, end_date=? WHERE journey_id=?");
    $stmt->bind_param("sssi", $journey_name, $start_date, $end_date, $journey_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Record updated successfully";
        header("Location: arrangement.php?journey_id=$journey_id");
    } else {
        echo "Error updating record: " . $stmt->error;
        header("Location: arrangement.php?journey_id=$journey_id");
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>