<?php
session_start();
?>

<style>
    .arrblock {
        width: 100px;
        border: 1px solid white;
        border-radius: 50px;
        color: black;
        margin: 25px;
        display: block;
        text-align: center;
        background-color: white;
    }

    .accblock {
        width: 100px;
        border: 1px solid white;
        border-radius: 50px;
        color: white;
        margin: 25px;
        display: block;
        text-align: center;
    }

    .accblock:hover {
        background-color: white;
        color: black;
    }

    .accblock:hover i {
        display: inline;
    }

    .accblock i {
        display: none;
    }

    .noteblock {
        width: 100px;
        border: 1px solid white;
        border-radius: 50px;
        color: white;
        margin: 25px;
        display: block;
        text-align: center;
        background-color: transparent;
        cursor: pointer;

    }

    .noteblock:hover {
        background-color: white;
        color: black;
    }

    .noteblock:hover i {
        display: inline;
    }

    .noteblock i {
        display: none;
    }

    .add-mem-button {
        width: 70px;
        height: 25px;
        color: black;
        cursor: pointer;

    }

    .add-mem-button:hover {
        background-color: lightgray;
    }

    .add-mem-button:active {
        background-color: darkgray;
    }
</style>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script></script>
    <?php

    // Create connection
    $conn = new mysqli('localhost', 'root', '12345678', 'travel');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $journey_id = $_GET['journey_id'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT journey_name FROM journey WHERE journey_id = ?");
    $stmt->bind_param("i", $journey_id);
    $stmt->execute();
    $stmt->bind_result($websiteName);
    $stmt->fetch();
    ?>
    <title><?php echo $websiteName; ?> - 安排行程</title>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div style="margin-left: 20%;">
        <?php
        $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
        $sql = "SELECT journey_name,start_date, end_date FROM journey WHERE journey_id = $journey_id";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result); // Fetch the result
        $start_date = $row['start_date']; // Populate start_date variable
        $end_date = $row['end_date']; // Populate end_date variable
        $sql = "SELECT * FROM arrangement WHERE journey_id = " . $journey_id;
        $result = mysqli_query($link, $sql);

        ?>
        <div style="display: flex; justify-content: center;">
            <a class="arrblock" href="arrangement.php?journey_id=<?php echo $journey_id; ?>">
                <i class="fi fi-rr-plane"></i>行程</a>
            <a class="accblock" href="accounting.php?journey_id=<?php echo $journey_id; ?>">
                <i class="fi fi-rr-hand-holding-usd"></i>記帳</a>
            <div style="justify-content: center; display:flex;">
                <!-- 備忘錄 -->
                <button type="button" id="click-note" class="noteblock" data-bs-toggle="modal" data-bs-target="#note" style="height: 25px; font-size:15px;">
                    <i class="fi fi-rr-memo-pad"></i>備忘錄
                </button>
                <button type="button" id="click-mem-edit" class="noteblock" data-bs-toggle="modal" data-bs-target="#mem-edit" style="height: 25px; font-size:15px;">
                    <i class="fi fi-rr-settings"></i>管理成員
                </button>

                <!-- 備忘錄Modal -->
                <div class="modal fade" id="note" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="exampleModalLabel">備忘錄</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                                <?php
                                $link = mysqli_connect("localhost", "root", "12345678", "travel");
                                $query = "SELECT content, note_id FROM note WHERE journey_id = $journey_id";
                                // Execute the query
                                $result = mysqli_query($link, $query);
                                if (!$result) {
                                    echo "Error executing query: " . mysqli_error($link);
                                } else {
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $note_id = $row['note_id'];
                                            echo "<div id='note-show'> ";
                                            echo "<p>" . $row['content'] . "</p>";
                                            echo "<div class='modal-footer'>";
                                            echo "<button id='note-edit' type='button' class='button'>編輯</button>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "<div  style='display:none;' id='note-edit-form'>";
                                            echo "<form id='note-edit' action='note-edit.php' method='post'>";
                                            echo "<input type='hidden' name='note_id' value='$note_id'>";
                                            echo "<input type='hidden' name='journey_id' value='$journey_id'>";
                                            echo "<textarea style='width:100%;height:800px;' name='note_content'>" . nl2br($row['content']) . "</textarea>";
                                            echo "<div class='modal-footer'>";
                                            echo "<input type='submit' class='button' value='儲存'>";
                                            echo "</div>";
                                            echo "</form>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<a href='note-create.php?journey_id=$journey_id'>新增備忘錄</a>";
                                    }
                                }
                                mysqli_close($link);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Edit members Modal -->
                <div class="modal fade" id="mem-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="exampleModalLabel">管理成員
                                    <button id="mem-add" class="add-mem-button"><i class="fi fi-rr-user-add"></i>&nbsp;新增</button>
                                    <button id="mem-del" class="add-mem-button"><i class="fa-solid fa-trash"></i>&nbsp;刪除</button>
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                                <div id="mem-show">
                                    <?php
                                    $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
                                    $query = "SELECT account.username FROM account 
                                JOIN journey_members ON account.address = journey_members.address
                                WHERE journey_members.journey_id = $journey_id";
                                    $result = mysqli_query($link, $query);

                                    echo "旅行成員:";
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<br>" . $row['username'];
                                    }

                                    mysqli_close($link);
                                    ?>
                                </div>
                                <div id="mem-add-form" style="display: none;">
                                    <form action="mem-add.php" method="post">
                                        <input type="hidden" name="journey_id" value="<?php echo $journey_id; ?>">
                                        <div style="margin-top: 20px;">
                                            <label for="mem-add">新增成員:</label><br>
                                            <?php
                                            echo '<table>';
                                            $address = $_SESSION['address'];
                                            $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
                                            $query = "SELECT account.username FROM account
                                        JOIN friends ON account.address = friends.fri_address 
                                        WHERE friends.my_address = '$address' AND account.address NOT IN (
                                        SELECT journey_members.address FROM journey_members WHERE journey_members.journey_id = $journey_id)";
                                            $result = mysqli_query($link, $query);
                                            // Fetch the result as an associative array
                                            $friends = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                            foreach ($friends as $friend) {
                                                echo '<tr>';
                                                echo "<td><input type='checkbox' name='mem-add[]' value='" . $friend['username'] . "' style='margin: 0 10px;'>" . $friend['username'] . "</td>";
                                                echo '</tr>';
                                            }
                                            // Query the database to get the friends' names where fri_address is current user's address
                                            $query = "SELECT account.username FROM account
                                        JOIN friends ON account.address = friends.my_address 
                                        WHERE friends.fri_address = '$address' AND account.address NOT IN (
                                        SELECT journey_members.address FROM journey_members WHERE journey_members.journey_id = $journey_id)";
                                            $result = mysqli_query($link, $query);

                                            // Fetch the result as an associative array
                                            $friends = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                            foreach ($friends as $friend) {
                                                echo '<tr>';
                                                echo "<td><input type='checkbox' name='mem-add[]' value='" . $friend['username'] . "' style='margin: 0 10px;'>" . $friend['username'] . "</td>";
                                                echo '</tr>';
                                            }

                                            echo '</table>';
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="button" value="儲存">
                                        </div>
                                    </form>
                                </div>
                                <div id="mem-del-form" style="display: none; ">
                                    <form action="mem-del.php" method="post">
                                        <input type="hidden" name="journey_id" value="<?php echo $journey_id; ?>">
                                        <div style="margin-top: 20px;">
                                            <label for="mem-del">移除成員:</label><br>
                                            <?php
                                            $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
                                            $query = "SELECT account.username FROM account 
                                    JOIN journey_members ON account.address = journey_members.address
                                    WHERE journey_members.journey_id = $journey_id AND journey_members.address != '$address'";
                                            $result = mysqli_query($link, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<input type='checkbox' name='mem-del[]' value='" . $row['username'] . "' style='margin: 0 10px;'>";
                                                echo $row['username'];
                                                echo "<br>";
                                            }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="button" value="儲存">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'journey_arr.php'; ?>
    </div>
    <div style="position: absolute; top: 100px; left: 0;">
        <?php include 'showjourney.php'; ?>
    </div>


</body>

</html>
<?php
$stmt->close();
$conn->close();
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the button, div, and form elements
        const editButton = document.getElementById('note-edit');
        const noteShow = document.getElementById('note-show');
        const editForm = document.getElementById('note-edit-form');

        // Function to toggle between displaying the form and the div
        function toggleEditForm() {
            if (editForm.style.display === 'none') {
                // Show the form and hide the div
                editForm.style.display = 'block';
                noteShow.style.display = 'none';
            } else {
                // Hide the form and show the div
                editForm.style.display = 'none';
                noteShow.style.display = 'block';
            }
        }

        // Event listener for the edit button
        editButton.addEventListener('click', function(e) {
            e.preventDefault();
            toggleEditForm();
        });
    });
    $(document).ready(function() {
        $("#mem-add").click(function() {
            $("#mem-add-form").show();
            $("#mem-del-form").hide();
            $("#mem-show").hide();
        });

        $("#mem-del").click(function() {
            $("#mem-del-form").show();
            $("#mem-add-form").hide();
            $("#mem-show").hide();
        });
    });
</script>