<?php
session_start(); // Start the session

// Create a database connection
$connection = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $from_address = $_POST['from_address'];
    $to_address = $_POST['to_address'];
    $journey_id = $_POST['journey_id'];
    $cashflow_date = $_POST['cashflow_date'];
    $cashflow_amount = $_POST['cashflow_amount'];
    $cashflow_note = $_POST['cashflow_note'];

    // Prepare an SQL statement
    $query = mysqli_prepare($connection, "INSERT INTO cashflow (journey_id, from_address, to_address, cashflow_date, cashflow_amount, cashflow_note) 
    VALUES (?, ?, ?, ?, ?, ?)");

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($query, "isssds", $journey_id, $from_address, $to_address, $cashflow_date, $cashflow_amount, $cashflow_note);

    // Execute the prepared statement
    $result = mysqli_stmt_execute($query);

    // Close the statement and the connection
    mysqli_stmt_close($query);
    mysqli_close($connection);

    if ($result) {
        header("Location: accounting.php?journey_id=$journey_id");
        exit;
    } else {
        header("Location: accounting.php?journey_id=$journey_id");
        exit;
    }
}
?>