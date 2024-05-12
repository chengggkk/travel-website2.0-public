<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $arr_id = $_POST['arr_id'];
    $location_id = $_POST['edit-location_id'];
    $arr_date = $_POST['arr_date'];
    $arr_time = $_POST['arr_time'];
    $arr_locate = $_POST['edit-search'];
    $journey_id = $_POST['journey_id'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '12345678', 'travel');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update data in the database
    $sql = "UPDATE arrangement SET location_id='$location_id', arr_date='$arr_date', arr_time='$arr_time' WHERE arrange_id='$arr_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: arrangement.php?journey_id=$journey_id");
        exit;
        } else {
            header("Location: arrangement.php?journey_id=$journey_id");
            exit;}
    }
?>