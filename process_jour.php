<?php
session_start(); // Start the session

// Get the form data
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$journey_name = $_POST['journey_name'];
$address = $_SESSION['address'];
// Get the checkbox data
$friends = $_POST['friend'];

// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare the SQL query to insert into journey table
$sql = "INSERT INTO journey (start_date, end_date, journey_name) VALUES ('$start_date', '$end_date', '$journey_name')";

// Execute the query
if (mysqli_query($link, $sql)) {    
    $journey_id = mysqli_insert_id($link);
    $_SESSION['status'] = "success";

    // Prepare the SQL query to insert into journey_members table
    $sql = "INSERT INTO journey_members (journey_id, address) VALUES ('$journey_id', '$address')";

    // Execute the query
    if (!mysqli_query($link, $sql)) {
    }

    // Add each friend to the journey
    foreach ($friends as $friend_address) {
        $sql = "INSERT INTO journey_members (journey_id, address) VALUES ('$journey_id', '$friend_address')";
        if (!mysqli_query($link, $sql)) {
            $_SESSION['message'] .= "\nError adding friend to journey: " . mysqli_error($link);
        }
    }

    header('Location: arrangement.php?journey_id=' . $journey_id);
}


else {
    $_SESSION['status'] = "fail";
}




// Redirect to index.php
// Close the connection
mysqli_close($link);
?>
