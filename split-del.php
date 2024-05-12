<?php
// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the journey_id from the form data
$split_id = $_GET['split_id'];
$journey_id = $_GET['journey_id'];

$query = "DELETE FROM split WHERE split_id = '$split_id'";
$result = mysqli_query($link, $query);
if (!$result) {
    echo ('Error: ' . mysqli_error($link)); // Print the error if the query fails
}
else {
    echo "Data deleted successfully";
    header('Location: accounting.php?journey_id=' . $journey_id);
    exit;
}

?>