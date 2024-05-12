<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  
<!-- navbar.php -->
<?php
session_start();
$username = $_SESSION['username'] ?? ''; // Get the name from the session
?>
<script src="https://kit.fontawesome.com/29a6af0e63.js" crossorigin="anonymous"></script>

<nav style="display: flex; align-items: center;">
  <a href="index.php"><img src="img/logo.png" alt="Logo" style="width:100px; height: 50px;"></a>

  <div class="search-space" style="position: relative; z-index: 1000;">
    <i class="fa-solid fa-magnifying-glass fa-lg" style="color: #ffffff;"></i>
    <input type="text" style="width: 1000px;height:35px; color:white;" class="search" placeholder="搜尋景點">
    <div id="search-results" style="margin-left:25px; position: absolute; width: 1000px; background: white; border-radius: 10px;"></div>
  </div>

  <div class="fridropdown">
    <button class="fribtn"><?php echo $username; ?></button>
    <div class="fri-content" style="display: none;">
      <a href="logout.php">log out</a>
    </div>
  </div>

  <div class="dropdown">
    <button class="dropbtn"><?php echo $username; ?></button>
    <div class="dropdown-content" style="display: none;">
      <a href="logout.php">log out</a>
    </div>
  </div>
</nav>


<script>
$(document).ready(function() {
  $('.dropbtn, .fribtn').click(function() {
    $(this).next('.dropdown-content, .fri-content').slideToggle();
  });

  $(document).click(function(e) {
    if (!$(e.target).closest('.dropdown, .fridropdown').length) {
      $('.dropdown-content, .fri-content').slideUp();
    }
  });
});


</script>
</body>
</html>
