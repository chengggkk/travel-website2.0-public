<link rel="stylesheet" href="modal.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .journey-table tr:not(:first-child):hover {
        background-color: #333333;
    }

    .journey-table tr {
        height: 50px;
        color: white;
        /* Add this line */
    }

    .journey-row.active:hover {
        background-color: lightgray;
    }

    .jour-edit {
        background-color: transparent;
        border-color: none;
        width: 27px;
        height: 27px;
        cursor: pointer;

    }

    .jour-edit:hover {
        background-color: gray;
        border-color: 1px solid white;
    }

    .jour-del {
        background-color: transparent;
        border-color: none;
        width: 50px;
        height: 27px;
        margin-right: 5px;
        color: red;
        cursor: pointer;

    }

    .jour-del:hover {
        background-color: transparent;
        border-color: 1px solid white;
        color: #FF9999;
    }

    .jour-save {
        background-color: transparent;
        border-color: white;
        width: 50px;
        height: 27px;
        color: white;
    }

    .jour-save:hover {
        background-color: lightgray;
        border-color: 1px solid white;
        color: black;
    }

    .create-button {
        background-color: transparent;
        border-color: none;
        width: 300px;
        height: 50px;
        color: white;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .create-button i {
        background-color: transparent;
    }

    .create-button:hover {
        background-color: gray;
        color: white;
    }
    .create-button:hover i{
        background-color: transparent;
    }


</style>

<?php

// Your PHP code to fetch and display journeys...

session_start(); // Start the session

// Get the address of the currently logged in user
$address = $_SESSION['address'];
$choosed = $_POST['choose_journey'];
// Connect to the database
$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare the SQL query
$query = "SELECT journey.start_date, journey.end_date, journey.journey_name, journey.journey_id FROM journey
          JOIN journey_members ON journey.journey_id = journey_members.journey_id 
          WHERE journey_members.address = '$address'";
// Execute the query
$result = mysqli_query($link, $query);

// Check if the query returned any results
if (mysqli_num_rows($result) > 0) {
    echo "<table class='journey-table' style='border-collapse: collapse; width: 300px;'>";
    echo "<tr style='border: 1px solid white;'>";
    echo "<th style='border: 1px solid white;' class='create-button' onclick=\"window.location.href='index.php'\">創建旅程<i class='fa-solid fa-plus'></i></th>";
    echo "</tr>";
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='journey-row' style='border: 1px solid white;'>";
        echo "<td style='display:flex; align-items: center; justify-content: space-between;'>";
        echo "<div id='jour-show-{$row['journey_id']}' style='display:flex;'>";
        echo "<a style='color:white;' href='arrangement.php?journey_id={$row['journey_id']}'>";
        echo "<div class='journey-name'>" . $row['journey_name'] . "</div>";
        echo "<div class='journey-date' style='margin-top:5px'>" . $row["start_date"] . " ~ " . $row['end_date'] . "</div>";
        echo "</a>";
        echo "<div style='margin-left:43px;margin-top:23px'>";
        echo "<button id='jour-edit-{$row['journey_id']}' name='jour-edit' class='jour-edit'><i class='fa-solid fa-gear' style='color: #ffffff;'></i></button> ";
        echo "<button type='button' class='jour-del' data-bs-toggle='modal' data-bs-target='#jour-del-check" . $row['journey_id'] . "'>刪除</button>";
        echo "</div>";
        echo "</div>";

        //modal
        echo "<div class='modal fade' id='jour-del-check" . $row['journey_id'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
        echo "<div class='modal-dialog'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header' style='color:black;'>";
        echo "<h1 class='modal-title' id='exampleModalLabel'>確認刪除</h1>";
        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>";
        echo "</div>";
        echo "<div class='modal-body modal-dialog modal-dialog-centered' style='color:black;'>";
        echo "<p>確定要刪除此行程嗎？</p>";
        echo "</div>";
        echo "<div class='modal-footer'>";
        echo "<a href='jour-del.php?journey_id={$row['journey_id']}' style='color:red;'>刪除</a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        echo "<div id='jour-edit-form-{$row['journey_id']}' style='display:none;'>";
        echo "<form action='jour-edit.php' method='post'>";
        echo "<input type='hidden' name='journey_id' value='{$row['journey_id']}'>";
        echo "<input type='text' name='journey_name' value='{$row['journey_name']}'><br>";
        echo "<div style='display:flex; margin-top:15px'>"; // Add a semicolon at the end of this line
        echo "<input type='date' name='start_date' value='{$row['start_date']}'>";
        echo "<input type='date' name='end_date' value='{$row['end_date']}'>";
        echo "<input class='jour-save' type='submit' value='Save'>";
        echo "</div>";
        echo "</form>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
            </div>
        </div>
    </div>
</body>
</html>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all the edit buttons
        const editButtons = document.querySelectorAll('.jour-edit');

        // Loop through each edit button
        editButtons.forEach(function(editButton) {
            // Get the journeyId from the button's id
            const journeyId = editButton.id.split('-')[2];

            const editForm = document.getElementById('jour-edit-form-' + journeyId);
            const jourShow = document.getElementById('jour-show-' + journeyId);
            const newJourneyNameInput = editForm.querySelector('input[name="journey_name"]');
            const saveButton = editForm.querySelector('input[type="submit"]');
            const journeyNameElement = jourShow.querySelector('.journey-name');

            // Function to toggle between displaying the edit form and the journey name
            function toggleEditForm() {
                if (editForm.style.display === 'none') {
                    // Show the edit form and hide the jour-show div
                    editForm.style.display = 'block';
                    jourShow.style.display = 'none';
                    // Set the input field value to the current journey name
                    newJourneyNameInput.value = journeyNameElement.textContent.trim();
                } else {
                    // Hide the edit form and show the jour-show div
                    editForm.style.display = 'none';
                    jourShow.style.display = 'flex';
                }
            }

            // Event listener for the edit button
            editButton.addEventListener('click', function(e) {
                e.preventDefault();
                toggleEditForm();
            });

            // Event listener for the save button
            saveButton.addEventListener('click', function() {
                // Get the new journey name from the input field
                const newJourneyName = newJourneyNameInput.value.trim();
                // Update the journey name element with the new name
                journeyNameElement.textContent = newJourneyName;
                // Hide the edit form and show the jour-show div
                toggleEditForm();
            });
        });
    });
</script>