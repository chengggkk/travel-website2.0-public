<?php

session_start(); // Start the session

$connection = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the new data from the POST request
$cost_id = $_POST['cost_id'];
$cost_date = $_POST['cost_date'];
$cost_cate = $_POST['cost_cate'];
$cost_amount = $_POST['cost_amount'];
$cost_note = $_POST['cost_note'];
$journey_id = $_POST['journey_id'];

// Update the cost record in the database
$sql = "UPDATE cost SET cost_date = '$cost_date', cost_cate = '$cost_cate', cost_amount = '$cost_amount', cost_note = '$cost_note' WHERE cost_id = $cost_id";
$result = mysqli_query($connection, $sql);

if ($result) {
    $_SESSION['message'] = "編輯成功"; // Store success message in session
} else {
    $_SESSION['message'] = "編輯失敗 " . mysqli_error($connection); // Store error message in session
}

mysqli_close($connection); // Close the database connection

header("Location: accounting.php?journey_id=$journey_id");

?>