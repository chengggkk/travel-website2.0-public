<?php
// process_tra.php

session_start(); // Start the session
// Get the address of the currently logged in user
$address = $_SESSION['address'];

// Get the current user's address from the session
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the current user's address from the session
$address = $_SESSION['address'];

// Query the database to get the friends' names
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Travel</title>
    <style>
        .tra_form>div {
            flex: 1;
            /* Make each div take up equal space */
        }

        .button {
            width: 100px;
            height: 50px;
            background-color: black;
            color: white;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #ffffff;
            color: #000000;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="modal.css">
</head>

<body>

    <!-- Button trigger modal -->
    <div align="center" style="margin-top: 25vh;">
        <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#create_jour">
            創建旅程
        </button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="create_jour" tabindex="-1" role="dialog" aria-labelledby="create_jourTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="create_jourTitle">創建旅程</h1>
                    <button type="button" data-bs-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
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
                                <label for="travel_name">Journey Name:</label><br>
                                <input type="text" id="journey_name" name="journey_name" style=" width:350px;margin: 0 50px;" required><br>
                            </div>
                            <div style="margin-top: 20px;">
                                <label for="travel_name">成員</label><br>
                                <?php
                                $query = "SELECT account.username, account.address FROM account 
                JOIN friends ON account.address = friends.fri_address 
                WHERE friends.my_address = '$address'";
                                $result = mysqli_query($link, $query);

                                $friends = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                foreach ($friends as $friend) {
                                    echo '<input type="checkbox" name="friend[]" value="' . $friend['address'] . '" style="margin: 0 10px;">';
                                    echo $friend['username'];
                                    echo '<span style="margin-left: 10px; color:gray;">';
                                    echo $friend['address'];
                                    echo '</span><br>';
                                }
                                $query = "SELECT account.username, account.address FROM account
                JOIN friends ON account.address = friends.my_address 
                WHERE friends.fri_address = '$address'";
                                $result = mysqli_query($link, $query);
                                $friends = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                foreach ($friends as $friend) {
                                    echo '<input type="checkbox" name="friend[]" value="' . $friend['address'] . '" style="margin: 0 10px; border-radius: 100%;">';
                                    echo $friend['username'];
                                    echo '<span style="margin-left: 10px; color:gray;">';
                                    echo $friend['address'];
                                    echo '</span><br>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer" style="display: flex;">
                    <input type="submit" id="add-journey" class="button" value="創建旅程" style="width: 500px;">
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>