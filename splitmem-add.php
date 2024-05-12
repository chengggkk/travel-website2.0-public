<?php
session_start(); // Start the session

$split_amounts = $_GET['split-amount'];
$split_members = $_GET['split-members'];
$journey_id = $_GET['journey_id'];

// Create a database connection
$connection = mysqli_connect('localhost', 'root', '12345678', 'travel');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (count($split_amounts) != count($split_members)) {
    $_SESSION['message'] = "The number of amounts does not match the number of members.";
    header("Location: accounting.php?journey_id=" . $journey_id);
    exit;
}

for ($i = 0; $i < count($split_amounts); $i++) {
    $amount = $split_amounts[$i];
    $address = $split_members[$i];

    $query = mysqli_prepare($connection, "INSERT INTO split_members (journey_id, address, split_amount) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($query, 'isd', $journey_id, $address, $amount);
    $result = mysqli_stmt_execute($query);

    if (!$result) {
        $_SESSION['message'] = "Insert failed: " . mysqli_stmt_error($query);
        header("Location: accounting.php?journey_id=" . $journey_id);
        exit;
    }

    mysqli_stmt_close($query);
}

$_SESSION['message'] = "Data inserted successfully.";

header("Location: accounting.php?journey_id=" . $journey_id);
exit;

mysqli_close($connection);
?>
