<?php

session_start(); // Start the session at the beginning of the file

// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the journey_id from the form data
$journey_id = $_GET['journey_id'];
$split_id = $_GET['split_id'];
// Get the selected members from the form data
$split_members = explode(',', $_GET['split_members']); // Deserialize the string back into an array
$split_amounts = explode(',', $_GET['split_amounts']); // Deserialize the string back into an array
// For each selected member, insert the row into the split_members table
foreach ($split_members as $index => $split_member) {
    // Get the individual amount for the member
    $individual_amount = $split_amounts[$index];
    if ($individual_amount != '') {
        // Insert the member and their amount into the database
        $sql = "INSERT INTO split_members (split_id, journey_id, address, split_amount, pay_state) VALUES ('$split_id', '$journey_id', '$split_member', '$individual_amount', '0')";
        $result = mysqli_query($link, $sql);
    }
}
    header("Location: accounting.php?journey_id=" . $journey_id);
    exit;
?>
