<?php

session_start(); // Start the session

$connection = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the new data from the POST request
$budget_id = $_POST['budget_id'];
$bud_cate = $_POST['bud_cate'];
$bud_amount = $_POST['bud_amount'];
$bud_note = $_POST['bud_note'];
$journey_id = $_POST['journey_id'];

// Update the budget record in the database
$sql = "UPDATE budget SET bud_cate = '$bud_cate', bud_amount = '$bud_amount', bud_note = '$bud_note' WHERE budget_id = $budget_id";
$result = mysqli_query($connection, $sql);

if ($result) {
    header("Location: accounting.php?journey_id=$journey_id");
} else {
    header("Location: accounting.php?journey_id=$journey_id");
}

mysqli_close($connection); // Close the database connection
?>