<?php
// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the journey_id from the form data
$journey_id = $_POST['journey_id'];

// Get the selected members from the form data
$selected_members = $_POST['mem-del'];

// For each selected member, delete the row from the journey_members table
foreach ($selected_members as $member_username) {
    // Get the member's address
    $query = "SELECT address FROM account WHERE username = '$member_username'";
    $result = mysqli_query($link, $query);
    $member = mysqli_fetch_assoc($result);
    $member_address = $member['address'];

    // Delete the member from the journey_members table
    $query = "DELETE FROM journey_members WHERE journey_id = '$journey_id' AND address = '$member_address'";
    mysqli_query($link, $query);
}

// Redirect the user back to the previous page or display a success message
header('Location: arrangement.php?journey_id=' . $journey_id);
?>