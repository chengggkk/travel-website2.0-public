<?php
session_start(); // Start the session
if (isset($_SESSION['message'])) {
    echo "<script type='text/javascript'>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);  // clear the value so it doesn't get shown again
}
?>

<style>
    .arrblock {
        width: 100px;
        border: 1px solid white;
        border-radius: 50px;
        color: white;
        margin: 25px;
        display: block;
        text-align: center;
        background-color: transparent;
    }

    .arrblock:hover {
        background-color: white;
        color: black;
    }

    .arrblock:hover i {
        display: inline;
    }

    .arrblock i {
        display: none;
    }


    .accblock {
        width: 100px;
        border: 1px solid white;
        border-radius: 50px;
        color: black;
        margin: 25px;
        display: block;
        text-align: center;
        background-color: white;
    }

    .addbutton {
        width: 100px;
        height: 100px;
        border: 1px solid black;
        color: black;
        margin: 25px;
        display: block;
        text-align: center;
        margin: 10px;
        border-radius: 10px;
    }

    .addbutton:hover {
        border: 7px solid lightblue;
    }

    .split-button {
        width: 230px;
        border: 1px solid white;
    }

    .split-button:hover {
        background-color: white;
        color: black;
        border: 1px solid black;
    }

    #split-average,
    #split-self {
        display: none;
    }

    .active {
        border: 1px solid black;
    }

    .show-table {
        width: 10%;
        height: 50px;
        border: 1px solid black;
        color: black;
        display: block;
        text-align: center;
        margin-top: 10px;
    }

    .show-table:hover {
        background-color: lightgray;
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

    .memblock {
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

    .memblock:hover {
        background-color: white;
        color: black;
    }

    .memblock:hover i {
        display: inline;
    }

    .memblock i {
        display: none;
    }

    .add-mem-button {
        width: 70px;
        height: 25px;
        color: black;
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
    <link rel='stylesheet' href='modal.css'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
                <button type="button" id="click-mem-edit" class="memblock" data-bs-toggle="modal" data-bs-target="#mem-edit" style="height: 25px; font-size:15px;">
                    <i class="fi fi-rr-settings"></i>管理成員
                </button>

                <!-- 備忘錄Modal -->
                <div class="modal fade" id="note" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="exampleModalLabel">備忘錄</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>
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
                                <div id="mem-del-form" style="display: none;">
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






        <script>
            var modal = new bootstrap.Modal(document.getElementById('exampleModalLong'))

            document.getElementById('openModalButton').addEventListener('click', function() {
                modal.show()
            })
        </script>
        <div style="display: flex; justify-content: center;">
            <button type="button" class="addbutton" data-bs-toggle="modal" data-bs-target="#add-budget">
                新增預算<img style="width: auto; height:50px;margin-top:5px;" src="img/icons8-book-64.png"></button>
            <button type="button" class="addbutton" data-bs-toggle="modal" data-bs-target="#add-cost">
                新增花費<img style="width: auto; height:50px; margin-top:5px;" src="img/icons8-money-40.png"></button>
            <button type="button" class="addbutton" data-bs-toggle="modal" data-bs-target="#add-cashflow">
                新增金流<img style="width: auto; height:50px; margin-top:5px;" src="img/icons8-business-48.png"></button>
            <button type="button" class="addbutton" data-bs-toggle="modal" data-bs-target="#add-split">
                新增分帳<img style="width: auto; height:50px; margin-top:5px;" src="img/icons8-users-100.png"></button>
        </div>
    </div>


    <!-- add budget -->
    <div class="modal fade" id="add-budget" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLongTitle">新增預算</h1>
                    <button type="button" data-bs-dismiss="modal" aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>
                </div>
                <div class="modal-body">
                    <form action="budget-add.php" method="post">
                        <input type="hidden" name="journey_id" value="<?php echo $journey_id; ?>">
                        <div style="margin-top: 20px;">
                            <label for="budget_name">類別:</label><br>
                            <select id="budget_cate" name="budget_cate" style="width: 350px; margin: 0 50px;" required>
                                <option value="食物" selected>食物</option>
                                <option value="交通">交通</option>
                                <option value="消費">消費</option>
                                <option value="娛樂">娛樂</option>
                                <option value="住宿">住宿</option>
                                <option value="其他">其他</option>
                            </select><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="budget_amount">預算:</label><br>
                            <input type="number" id="budget_amount" name="budget_amount" style=" width:350px;margin: 0 50px;" required><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="budget_note">Note:</label><br>
                            <input type="text" id="budget_note" name="budget_note" style=" width:350px;margin: 0 50px;" required><br>
                        </div>
                </div>
                <div class="modal-footer" style="display: flex;">
                    <input type="submit" id="add-journey" class="button" value="新增" style="width: 500px;">
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- add cost -->
    <div class="modal fade" id="add-cost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLongTitle">新增花費</h1>
                    <button type="button" data-bs-dismiss="modal"aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>
                </div>
                <div class="modal-body">
                    <form action="cost-add.php" method="post">
                        <input type="hidden" name="journey_id" value="<?php echo $journey_id; ?>">
                        <div style="margin-top: 20px;">
                            <label for="cost_cate">類別:</label><br>
                            <select id="cost_cate" name="cost_cate" style="width: 350px; margin: 0 50px;" required>
                                <option value="食物" selected>食物</option>
                                <option value="交通">交通</option>
                                <option value="消費">消費</option>
                                <option value="娛樂">娛樂</option>
                                <option value="住宿">住宿</option>
                                <option value="其他">其他</option>
                            </select><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="cost_date">日期:</label><br>
                            <input type="date" id="cost_date" name="cost_date" style=" width:350px;margin: 0 50px;" required value="<?php echo date('Y-m-d'); ?>"><br>
                            <div style="margin-top: 20px;">
                                <label for="cost_amount">金額:</label><br>
                                <input type="number" id="cost_amount" name="cost_amount" style=" width:350px;margin: 0 50px;" required><br>
                            </div>
                            <div style="margin-top: 20px;">
                                <label for="cost_note">Note:</label><br>
                                <input type="text" id="cost_note" name="cost_note" style=" width:350px;margin: 0 50px;" required><br>
                            </div>
                        </div>
                        <div class="modal-footer" style="display: flex;">
                            <input type="submit" id="add-journey" class="button" value="新增" style="width: 500px;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- add cashflow -->
    <div class="modal fade" id="add-cashflow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLongTitle">新增金流</h1>
                    <button type="button" data-bs-dismiss="modal"aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>
                </div>
                <div class="modal-body">
                    <form action="cashflow-add.php" method="post">
                        <input type="hidden" name="journey_id" value="<?php echo $journey_id; ?>">
                        <div style="margin-top: 20px;">
                            <label for="from_address">From:</label><br>
                            <select id="from_address" name="from_address" style=" width:350px;margin: 0 50px;" required>
                            <?php
                                $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
                                $query = "SELECT account.username, account.address FROM account 
                                JOIN journey_members ON account.address = journey_members.address
                                WHERE journey_members.journey_id = $journey_id";
                                $result = mysqli_query($link, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='". $row['address'] ."'>" . $row['username'] . "</option>";
                                }
                                ?>
                            </select><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="to_address">To:</label><br>
                            <select id="to_address" name="to_address" style=" width:350px;margin: 0 50px;" required>
                                <?php
                                $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
                                $query = "SELECT account.username, account.address FROM account 
                                JOIN journey_members ON account.address = journey_members.address
                                WHERE journey_members.journey_id = $journey_id";
                                $result = mysqli_query($link, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='". $row['address'] ."'>" . $row['username'] . "</option>";
                                }
                                ?>
                            </select><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="cashflow_date">日期:</label><br>
                            <input type="date" id="cashflow_date" name="cashflow_date" style=" width:350px;margin: 0 50px;" required value="<?php echo date('Y-m-d'); ?>"><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="cashflow_amount">金額:</label><br>
                            <input type="number" id="cashflow_amount" name="cashflow_amount" style=" width:350px;margin: 0 50px;" required><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="cashflow_note">Note:</label><br>
                            <input type="text" id="cashflow_note" name="cashflow_note" style=" width:350px;margin: 0 50px;" required><br>
                        </div>
                </div>
                <div class="modal-footer" style="display: flex;">
                    <input type="submit" id="add-journey" class="button" value="新增" style="width: 500px;">
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- add split -->

    <div class="modal fade" id="add-split" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLongTitle">新增分帳</h1>
                    <button type="button" data-bs-dismiss="modal"aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>
                </div>
                <div class="modal-body">
                    <button class="split-button" id="average">平分</button>
                    <button class="split-button" id="self">自訂</button>

                    <form action="split-add-ave.php" method="post" id="split-average">
                        <input type="hidden" name="journey_id" value="<?php echo $journey_id; ?>">
                        <div style="margin-top: 20px;">
                            <label for="split_cate">類別:</label><br>
                            <select id="split_cate" name="split_cate" style="width: 350px; margin: 0 50px;" required>
                                <option value="食物" selected>食物</option>
                                <option value="交通">交通</option>
                                <option value="消費">消費</option>
                                <option value="娛樂">娛樂</option>
                                <option value="住宿">住宿</option>
                                <option value="其他">其他</option>
                            </select><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="split_total">總額:</label><br>
                            <input type="number" id="split_total" name="split_total" style=" width:350px;margin: 0 50px;" required><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="split_date">日期:</label><br>
                            <input type="date" id="split_date" name="split_date" style=" width:350px;margin: 0 50px;" required value="<?php echo date('Y-m-d'); ?>"><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label>付款人</label><br>
                            <select id="payer" name="payer" style=" width:350px;margin: 0 50px;" required>
                                <?php
                                $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
                                $query = "SELECT account.username, account.address FROM account 
                                JOIN journey_members ON account.address = journey_members.address
                                WHERE journey_members.journey_id = $journey_id";
                                $result = mysqli_query($link, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['address'] . "'>" . $row['username'] . "</option>";
                                }
                                ?>
                            </select><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label>參與者</label><br>
                            <input type="checkbox" id="select-all">全選</input><br>
                            <?php
                            $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
                            $query = "SELECT account.username, account.address FROM account 
                                JOIN journey_members ON account.address = journey_members.address
                                WHERE journey_members.journey_id = $journey_id";
                            $result = mysqli_query($link, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<input type='checkbox' class='checkbox' name=\"split_members[]\" value='" . $row['address'] . "'>" . $row['username'] . "</input>";
                            }
                            ?>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="split_note">Note:</label><br>
                            <input type="text" id="split_note" name="split_note" style=" width:350px;margin: 0 50px;" required><br>
                        </div>
                        <div class="modal-footer" style="display: flex;">
                            <input type="submit" id="add-journey" class="button" value="新增" style="width: 500px;">
                        </div>
                    </form>


                    <!-- split self -->
                    <form action="split-add.php" method="post" id="split-self">
                        <input type="hidden" name="journey_id" value="<?php echo $journey_id; ?>">
                        <div style="margin-top: 20px;">
                            <label for="split_cate">類別:</label><br>
                            <select id="split_cate" name="split_cate" style="width: 350px; margin: 0 50px;" required>
                                <option value="食物" selected>食物</option>
                                <option value="交通">交通</option>
                                <option value="消費">消費</option>
                                <option value="娛樂">娛樂</option>
                                <option value="住宿">住宿</option>
                                <option value="其他">其他</option>
                            </select><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="split_date">日期:</label><br>
                            <input type="date" id="split_date" name="split_date" style=" width:350px;margin: 0 50px;" required value="<?php echo date('Y-m-d'); ?>"><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label>付款人</label><br>
                            <select id="payer" name="payer" style=" width:350px;margin: 0 50px;" required>
                                <?php
                                $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
                                $query = "SELECT account.username FROM account 
                                JOIN journey_members ON account.address = journey_members.address
                                WHERE journey_members.journey_id = $journey_id";
                                $result = mysqli_query($link, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option>" . $row['username'] . "</option>";
                                }
                                ?>
                            </select><br>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="split_name">參與人員:</label><br>
                            <table id="split-table" style="border-collapse: collapse; width: 100%;">
                                <tr>
                                    <th>人員</th>
                                    <th>金額</th>
                                </tr>
                                <?php
                                $link = mysqli_connect('localhost', 'root', '12345678', 'travel');
                                $query = "SELECT account.username, account.address FROM account 
                                JOIN journey_members ON account.address = journey_members.address
                                WHERE journey_members.journey_id = $journey_id";
                                $result = mysqli_query($link, $query);
                                $index = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td><input type='text' style=\"width:100%;\" value='" . $row['username'] . "' disabled>";
                                    echo "<input type='hidden' name=\"split_members[]\" value='" . $row['address'] . "'></td>";
                                    echo "<td><input style=\"width:100%;\" type=\"number\" name=\"split_amounts[]\"></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        </div>
                        <div style="margin-top: 20px;">
                            <label for="split_note">Note:</label><br>
                            <input type="text" id="split_note" name="split_note" style=" width:350px;margin: 0 50px;" required><br>
                        </div>
                        <div class="modal-footer" style="display: flex;">
                            <input type="submit" class="button" value="新增" style="width: 500px;">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div style="display:flex; justify-content: center; margin-left:20%;">
        <button id="budget-show" class="show-table">預算</button>
        <button id="cost-show" class="show-table">花費</button>
        <button id="cashflow-show" class="show-table">金流</button>
        <button id="split-show" class="show-table">分帳</button>
        <button id="total-show" class="show-table">總結</button>
    </div>
<div style="margin-left: 20%;">
    <div id="budget-display" style="display: none;">
        <?php include 'budget-show.php'; ?>
    </div>

    <div id="cost-display" style="display: none;">
        <?php include 'cost-show.php'; ?>
    </div>
    <div id="cashflow-display" style="display: none;">
        <?php include 'cashflow-show.php'; ?>
    </div>
    <div id="split-display" style="display: none;">
        <?php include 'split-show.php'; ?>
    </div>
    <div id="total-display" style="display: none;">
        <?php include 'total-show.php'; ?>
    </div>
</div>
    <div style="position: absolute; top: 100px; left: 0;">
        <?php include 'showjourney.php'; ?>
    </div>
</body>

</html>
<?php
$stmt->close();
$conn->close();
mysqli_close($link);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    // budget
    $(document).ready(function() {
        $("#budget-show").click(function() {
            var journey_id = <?php echo $journey_id; ?>; // Assuming $journey_id is available in this scope
            if ($("#budget-display").css("display") === "block") {
                $("#budget-display").css("display", "none");
            } else {
                $.ajax({
                    url: 'budget-show.php',
                    type: 'get',
                    data: {
                        journey_id: journey_id
                    },
                    success: function(response) {
                        $("#budget-display").css("display", "block");
                        $("#cost-display").css("display", "none");
                        $("#cashflow-display").css("display", "none");
                        $("#split-display").css("display", "none");
                        $("#total-display").css("display", "none");
                    }
                });
            }
        });
    });
    // cost
    $(document).ready(function() {
        $("#cost-show").click(function() {
            var journey_id = <?php echo $journey_id; ?>; // Assuming $journey_id is available in this scope
            if ($("#cost-display").css("display") === "block") {
                $("#cost-display").css("display", "none");
            } else {
                $.ajax({
                    url: 'cost-show.php',
                    type: 'get',
                    data: {
                        journey_id: journey_id
                    },
                    success: function(response) {
                        $("#budget-display").css("display", "none");
                        $("#cost-display").css("display", "block");
                        $("#cashflow-display").css("display", "none");
                        $("#split-display").css("display", "none");
                        $("#total-display").css("display", "none");
                    }
                });
            }
        });
    });
    // cashflow
    $(document).ready(function() {
        $("#cashflow-show").click(function() {
            var journey_id = <?php echo $journey_id; ?>; // Assuming $journey_id is available in this scope
            if ($("#cashflow-display").css("display") === "block") {
                $("#cashflow-display").css("display", "none");
            } else {
                $.ajax({
                    url: 'cashflow-show.php',
                    type: 'get',
                    data: {
                        journey_id: journey_id
                    },
                    success: function(response) {
                        $("#budget-display").css("display", "none");
                        $("#cost-display").css("display", "none");
                        $("#cashflow-display").css("display", "block");
                        $("#split-display").css("display", "none");
                        $("#total-display").css("display", "none");
                    }
                });
            }
        });
    });
    $(document).ready(function() {
        $("#split-show").click(function() {
            var journey_id = <?php echo $journey_id; ?>; // Assuming $journey_id is available in this scope
            if ($("#split-display").css("display") === "block") {
                $("#split-display").css("display", "none");
            } else {
                $.ajax({
                    url: 'split-show.php',
                    type: 'get',
                    data: {
                        journey_id: journey_id
                    },
                    success: function(response) {
                        $("#budget-display").css("display", "none");
                        $("#cost-display").css("display", "none");
                        $("#cashflow-display").css("display", "none");
                        $("#split-display").css("display", "block");
                        $("#total-display").css("display", "none");
                    }
                });
            }
        });
    });
    $(document).ready(function() {
        $("#total-show").click(function() {
            var journey_id = <?php echo $journey_id; ?>; // Assuming $journey_id is available in this scope
            if ($("#total-display").css("display") === "block") {
                $("#total-display").css("display", "none");
            } else {
                $.ajax({
                    url: 'split-show.php',
                    type: 'get',
                    data: {
                        journey_id: journey_id
                    },
                    success: function(response) {
                        $("#budget-display").css("display", "none");
                        $("#cost-display").css("display", "none");
                        $("#cashflow-display").css("display", "none");
                        $("#split-display").css("display", "none");
                        $("#total-display").css("display", "block");
                    }
                });
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners for the buttons
        document.getElementById('average').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('split-average').style.display = 'block';
            document.getElementById('split-self').style.display = 'none';
            document.getElementById('self').classList.remove('active');
        });

        document.getElementById('self').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('split-self').style.display = 'block';
            document.getElementById('split-average').style.display = 'none';
            document.getElementById('average').classList.remove('active');
        });

        // Simulate a click on the "average" button
        document.getElementById('average').click();
    });
    document.getElementById('select-all').addEventListener('change', function() {
        var checkboxes = document.getElementsByClassName('checkbox');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
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