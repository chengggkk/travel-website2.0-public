<?php

session_start(); // Start the session

$connection = mysqli_connect('localhost', 'root', '12345678', 'travel');
$journey_id = $_GET['journey_id'];

$sql = "INSERT INTO note (journey_id, content) VALUES ($journey_id, 'New Note')";
$result = mysqli_query($connection, $sql);

if ($result) {
    header("Location: arrangement.php?journey_id=$journey_id"); // Redirect to another page

} else {
}

mysqli_close($connection); // Close the database connection


?>