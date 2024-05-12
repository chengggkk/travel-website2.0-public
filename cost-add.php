<?php
session_start(); // Start the session

// Create a database connection
$connection = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $address = $_SESSION['address'];
    $journey_id = $_POST['journey_id'];
    $cost_cate = $_POST['cost_cate'];
    $cost_date = $_POST['cost_date'];
    $cost_amount = $_POST['cost_amount'];
    $cost_note = $_POST['cost_note'];

    // Prepare an SQL statement
    $query = mysqli_prepare($connection, "INSERT INTO cost (journey_id, address, cost_date, cost_cate, cost_amount, cost_note) 
    VALUES (?, ?, ?, ?, ?, ?)");

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($query, "isssds", $journey_id, $address, $cost_date, $cost_cate, $cost_amount, $cost_note);

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