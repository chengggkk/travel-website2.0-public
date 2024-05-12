<?php
session_start(); // Start the session at the beginning of the file

// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the journey_id from the form data
$journey_id = $_POST['journey_id'];

// Get the selected members from the form data
$split_category = $_POST['split_cate'];
$split_date = $_POST['split_date'];
$payer = $_POST['payer'];
$split_members = $_POST['split_members'];
$split_amounts = $_POST['split_amounts'];
$split_note = $_POST['split_note'];

$sql = "INSERT INTO split (journey_id, split_cate, split_date, split_payer, split_note) VALUES ('$journey_id', '$split_category', '$split_date', '$payer', '$split_note')";


if (mysqli_query($link, $sql)) {
    $split_id = mysqli_insert_id($link); // Get the ID of the last inserted row
    echo "Data inserted successfully"; // Store the success message in the session
    echo $split_id;
    $split_members_string = implode(',', $split_members); // Serialize the array
    $split_amounts_string = implode(',', $split_amounts); // Serialize the array
    header("Location: split-add-mem.php?journey_id=$journey_id&split_members=$split_members_string&split_amounts=$split_amounts_string&split_id=$split_id"); // Redirect to the accounting page
    exit;
} else {
    echo "Error: " . mysqli_error($link); // Store the error message in the session
}
