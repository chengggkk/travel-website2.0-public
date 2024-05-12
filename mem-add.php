<?php
// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the journey_id from the form data
$journey_id = $_POST['journey_id'];

// Get the selected friends from the form data
$selected_friends = $_POST['mem-add'];

// For each selected friend, insert a row into the journey_members table
foreach ($selected_friends as $friend_username) {
    // Get the friend's address
    $query = "SELECT address FROM account WHERE username = '$friend_username'";
    $result = mysqli_query($link, $query);
    $friend = mysqli_fetch_assoc($result);
    $friend_address = $friend['address'];

    // Insert the friend into the journey_members table
    $query = "INSERT INTO journey_members (journey_id, address) VALUES ('$journey_id', '$friend_address')";
    mysqli_query($link, $query);
}

// Redirect the user back to the previous page or display a success message
header('Location: arrangement.php?journey_id=' . $journey_id);
?>