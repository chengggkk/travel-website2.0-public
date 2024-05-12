<?php
session_start();

// Connect to your database
$address = $_POST['address'];

// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Assume the friend's address is posted from a form
$friend_address = $_POST['friend_address'];

// Check if the friend's address exists in the users table
$query = "SELECT * FROM account WHERE address = '$friend_address'";
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) > 0) {
    // If the friend exists, add them to the user's friend list
    $my_address = $_SESSION['address'];
    $query = "INSERT INTO friends (my_address, fri_address) VALUES ('$my_address', '$friend_address')";
    if (mysqli_query($link, $query)) {
    } else {
    }
} else {
    // If the friend does not exist, set an error message
    $_SESSION['no_acc_message'] = "找無此帳號";
}

// Redirect back to the previous page
header('Location: index.php');
