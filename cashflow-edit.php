<?php

session_start(); // Start the session

$connection = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the new data from the POST request
$cashflow_id = $_POST['cashflow_id'];
$from_address = $_POST['from_address'];
$to_address = $_POST['to_address'];
$cashflow_date = $_POST['cashflow_date'];
$cashflow_amount = $_POST['cashflow_amount'];
$cashflow_note = $_POST['cashflow_note'];
$journey_id = $_POST['journey_id'];

// Update the cashflow record in the database
$sql = "UPDATE cashflow SET from_address = '$from_address', to_address = '$to_address', cashflow_date = '$cashflow_date', cashflow_amount = '$cashflow_amount', cashflow_note = '$cashflow_note' WHERE cashflow_id = $cashflow_id";
$result = mysqli_query($connection, $sql);

if ($result) {
    header("Location: accounting.php?journey_id=$journey_id");
} else {
    header("Location: accounting.php?journey_id=$journey_id");
}

mysqli_close($connection); // Close the database connection
?>