<?php
// index.php
session_start(); // Start the session
if (!isset($_SESSION['address'])) {
  header('Location: login.php');
  exit;
}
if (isset($_SESSION['message'])) {
  echo "<script>alert('{$_SESSION['message']}');</script>";

  unset($_SESSION['message']);
  unset($_SESSION['status']);
}
?>

<style>
  .tra_form {
    margin-top: 100px;
    top: 100px;
    left: 0;
    width: 500px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: white;
  }

  .button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 10px;
  }

  .button:hover {
    background-color: #45a049;
    border: black 1px solid;
  }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
  <?php include 'navbar.php'; ?>
  <div style="margin-left:45%; display:flex;">
    <form class="tra_form" action="process_jour.php" method="post">
      <div>
        <input type="hidden" name="address" value="<?php echo $address; ?>">
        <div style="display: flex;">
          <div>
            <label for="start_date">Start Date:</label><br>
            <input type="date" id="start_date" name="start_date" style="margin: 0 50px;" required><br>
          </div>
          <div>
            <label for="end_date">End Date:</label><br>
            <input type="date" id="end_date" name="end_date" style="margin: 0 50px;" required><br>
          </div>
        </div>
        <div style="margin-top: 20px;">
          <label for="travel_name">旅行名稱:</label><br>
          <input type="text" id="journey_name" name="journey_name" style=" width:350px;margin: 0 50px;" required><br>
        </div>
        <div style="margin-top: 20px;">
          <label for="travel_name">成員</label><br>
          <?php
          $myquery = "SELECT account.username, account.address FROM account 
                JOIN friends ON account.address = friends.fri_address 
                WHERE friends.my_address = '$address'";
          $myresult = mysqli_query($link, $myquery);

          $friends = mysqli_fetch_all($myresult, MYSQLI_ASSOC);
          foreach ($friends as $friend) {
            echo '<input type="checkbox" name="friend[]" value="' . $friend['address'] . '" style="margin: 0 10px;">';
            echo $friend['username'];
            echo '<span style="margin-left: 10px; color:gray;">';
            echo $friend['address'];
            echo '</span><br>';
          }
          $friquery = "SELECT account.username, account.address FROM account
                JOIN friends ON account.address = friends.my_address 
                WHERE friends.fri_address = '$address'";
          $friresult = mysqli_query($link, $friquery);
          $friends = mysqli_fetch_all($friresult, MYSQLI_ASSOC);
          foreach ($friends as $friend) {
            echo '<input type="checkbox" name="friend[]" value="' . $friend['address'] . '" style="margin: 0 10px; border-radius: 100%;">';
            echo $friend['username'];
            echo '<span style="margin-left: 10px; color:gray;">';
            echo $friend['address'];
            echo '</span><br>';
          }
          mysqli_close($link);

          ?>
        </div>
      </div>

      <div class="modal-footer" style="display: flex;">
        <input type="submit" id="add-journey" class="button" value="創建旅程" style="width: 500px;">
      </div>
    </form>
  </div>
  <div style="position: absolute; top: 100px; left: 0;">
    <?php include 'showjourney.php'; ?>
  </div>
</body>

</html>