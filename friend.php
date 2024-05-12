<style>
.friend-table {
  width: 100%;
  border-collapse: collapse;
  color: black;
}

.friend-table th, .friend-table td {
  border: 1px solid #dddddd;
  padding: 8px;
  text-align: left;
}

.hover-effect:hover {
  background-color: #333333;
  color: white;
}
</style>

<?php
// Start the session
session_start();

// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the current user's address from the session
$address = $_SESSION['address'];

// Display the friend list in a table
echo '<table class="friend-table">';
echo '<form action="process_addfri.php" method="post">';
echo '<input type="text" name="friend_address" placeholder="輸入帳號" required></input> <input type="submit" value="新增好友"></input>';
if (isset($_SESSION['no_acc_message'])) {
    echo '<p style="color: red;">' . $_SESSION['no_acc_message'] . '</p>';
    unset($_SESSION['no_acc_message']);
}
echo '</form>';

// Query the database to get the friends' names where my_address is current user's address
$query = "SELECT account.username FROM account
          JOIN friends ON account.address = friends.fri_address 
          WHERE friends.my_address = '$address'";
$result = mysqli_query($link, $query);

// Fetch the result as an associative array
$friends = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($friends as $friend) {
    echo '<tr class="hover-effect">';
    echo '<td>' . $friend['username'] . '</td>';
    echo '</tr>';
}

// Query the database to get the friends' names where fri_address is current user's address
$query = "SELECT account.username FROM account
          JOIN friends ON account.address = friends.my_address 
          WHERE friends.fri_address = '$address'";
$result = mysqli_query($link, $query);

// Fetch the result as an associative array
$friends = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($friends as $friend) {
    echo '<tr class="hover-effect">';
    echo '<td>' . $friend['username'] . '</td>';
    echo '</tr>';
}

echo '</table>';
?>
