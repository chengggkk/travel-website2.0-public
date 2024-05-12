<?php
session_start(); // Start the session

// Create a database connection
$connection = mysqli_connect('localhost', 'root','12345678', 'travel');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $journey_id = $_POST['journey_id'];
    $budget_cate = $_POST['budget_cate'];
    $budget_amount = $_POST['budget_amount'];
    $budget_note = $_POST['budget_note'];

    // Prepare an SQL statement
    $stmt = mysqli_prepare($connection, "INSERT INTO budget (journey_id, bud_cate, bud_amount, bud_note) VALUES (?, ?, ?, ?)");

    // Bind the variables to the prepared statement
    mysqli_stmt_bind_param($stmt, 'isds', $journey_id, $budget_cate, $budget_amount, $budget_note);

    // Execute the prepared statement
    $result = mysqli_stmt_execute($stmt);

    // Close the statement and the connection
    mysqli_stmt_close($stmt);
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