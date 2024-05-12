<?php
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');
$journey_id = $_GET['journey_id'];
$query = "SELECT account.username FROM account 
          JOIN journey_members ON account.address = journey_members.address 
          WHERE journey_members.journey_id = $journey_id";
$result = mysqli_query($link, $query);
$members = array();
while ($row = mysqli_fetch_assoc($result)) {
    $members[] = $row['username'];
}
echo json_encode($members);
?>