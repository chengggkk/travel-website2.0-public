<?php

session_start(); // Start the session

$connection = mysqli_connect('localhost', 'root', '12345678', 'travel');
$note_id = $_POST['note_id'];
$note_content = $_POST['note_content'];
$journey_id = $_POST['journey_id'];

// 在 SQL 查询中直接使用 note_content
$sql = "UPDATE note SET content = '$note_content' WHERE note_id = $note_id";
$result = mysqli_query($connection, $sql);

if ($result) {
    header("Location: arrangement.php?journey_id=$journey_id");
} else {
    header("Location: arrangement.php?journey_id=$journey_id");
}

mysqli_close($connection); // Close the database connection
?>
