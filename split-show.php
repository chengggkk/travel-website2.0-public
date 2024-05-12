<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="modal.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <style>
        #budget-table td {
            border: 1px solid white;
            width: 1000px;
            height: 50px;
            color: white;
        }

        #budget-table th {
            border: 1px solid white;
            width: 1000px;
            height: 50px;
            color: white;
        }

        #budget-table tr {
            height: 50px;
            color: white;
            width: 1000px;
            height: 50px;
            color: white;
        }

        #split-pay-table td {
            border: 1px solid red;
            width: 1000px;
        }

        #split-pay-table tr {
            border: 1px solid red;
            width: 1000px;
            height: 50px;
            color: white;
        }

        #split-pay-table th {
            border: 1px solid red;
            width: 1000px;
            height: 50px;
            color: white;
        }
        .btn-primary{
            background-color: transparent;
            border: none;
            width: 50px;
            height: 50px;
        }
        .btn-primary:hover{
            background-color: transparent;
            border: 1px solid white;
            width: 50px;
            height: 50px;
        }
    </style>

    <?php
    session_start(); // Start the session

    // Get the address of the currently logged in user
    $journey_id = $_GET['journey_id'];
    $address = $_SESSION['address'];
    // Connect to the database
    $link = mysqli_connect('localhost', 'root', '12345678', 'travel');

    // Check connection
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Prepare the SQL query
    $query = "SELECT split_id, split_cate, split_date, split_note FROM split WHERE journey_id = '$journey_id' AND split_payer = '$address'";

    // Execute the query
    $result = mysqli_query($link, $query);
    // Check if the query returned any results
    if (mysqli_num_rows($result) > 0) {
        echo "<table id='split-pay-table' style='border-collapse: collapse; display:flex; justify-content:center; color:white; text-align:center;'>";
        echo "<tr style='border: 1px solid white;'>";
        echo "<td style='border: 1px solid white;'>類別</th>";
        echo "<td style='border: 1px solid white;'>日期</th>";
        echo "<td style='border: 1px solid white;'>Note</th>";
        echo "<td style='border: 1px solid white;'>刪除</th>";
        echo "<td style='border: 1px solid white;'>編輯</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $split_id = $row['split_id'];

            echo "<tr>";
            echo "<td style='border: 1px solid white;'>" . $row['split_cate'] . "</td><td style='border: 1px solid white;'>" . $row['split_date'] . "</td><td style='border: 1px solid white;'>" . $row['split_note'] . "</td>";
            echo "<td style='border: 1px solid white;'><a href='split-del.php?split_id=$split_id&journey_id=$journey_id' style='color:red;'>刪除</a></td>";
            echo "<td style='border: 1px solid white;'><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#split-edit-$split_id'><i class='fa-solid fa-gear' style='color: #ffffff;'></i></button></td>";
            echo "</tr>";
            echo "<tr style='border: 1px solid lightgreen;'>";
            echo "<td style='border: 1px solid lightgreen;'>從</th>";
            echo "<td style='border: 1px solid lightgreen;'>欠款金額</th>";
            echo "<td style='border: 1px solid lightgreen;'>是否付款</th>";
            echo "<td style='border: 1px solid lightgreen;'></th>";
            echo "<td style='border: 1px solid lightgreen;'></th>";
            echo "</tr>";



            //Ourside modal
            echo "<div class='modal fade' id='split-edit-$split_id' tabindex='-1' aria-labelledby='split-edit-$split_id' aria-hidden='true'>";
            echo "<div class='modal-dialog'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h1 class='modal-title' id='split-edit'>編輯分帳";
            echo "</h1>";
            echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "<form action='split-edit.php' method='post'>";
            echo "<input type='hidden' name='split_id' value='$split_id'>";
            echo "<input type='hidden' name='journey_id' value='$journey_id'>";
            echo "<div style='margin-top: 20px;'>";
            echo "<label for='split_cate' class='col-form-label'>類別:</label>";
            echo "<select id='split_cate' name='split_cate' style='width: 350px; margin: 0 50px;' required>";
            echo "<option value='食物'" . ($row['split_cate'] == '食物' ? ' selected' : '') . ">食物</option>";
            echo "<option value='交通'" . ($row['split_cate'] == '交通' ? ' selected' : '') . ">交通</option>";
            echo "<option value='消費'" . ($row['split_cate'] == '消費' ? ' selected' : '') . ">消費</option>";
            echo "<option value='娛樂'" . ($row['split_cate'] == '娛樂' ? ' selected' : '') . ">娛樂</option>";
            echo "<option value='住宿'" . ($row['split_cate'] == '住宿' ? ' selected' : '') . ">住宿</option>";
            echo "<option value='其他'" . ($row['split_cate'] == '其他' ? ' selected' : '') . ">其他</option>";
            echo "</select><br>";
            echo "</div>";
            echo "<div style='margin-top: 20px;'>";
            echo "<label for='split_date'>日期:</label><br>";
            echo "<input type='date' id='split_date' name='split_date' style=' width:350px;margin: 0 50px;' value='" . $row['split_date'] . "' required><br>";
            echo "</div>";
            echo "<div style='margin-top: 20px;'>";
            echo "<label for='split_note'>Note:</label><br>";
            echo "<input type='text' id='split_note' name='split_note' style=' width:350px;margin: 0 50px;' value='" . $row['split_note'] . "' required><br>";
            echo "</div>";
            echo "<div class='modal-footer' style='display: flex;'>";
            echo "<input type='submit' id='add-journey' class='button' value='儲存' style='width: 500px;'>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";



            //innerRow
            $innerQuery = "SELECT split_members.split_id, split_members.split_amount, split_members.address, split_members.pay_state, account.username
        FROM split_members 
        JOIN account ON split_members.address = account.address
        WHERE split_members.split_id = '$split_id' AND split_members.address != '$address'";
            $innerResult = mysqli_query($link, $innerQuery);
            // Output data of each row
            while ($innerRow = mysqli_fetch_assoc($innerResult)) {
                echo "<tr style='border: 1px solid lightgreen;'>";
                echo "<td style='border: 1px solid lightgreen;'>" . $innerRow['username'] . "</td><td style='border: 1px solid lightgreen;'>" . $innerRow["split_amount"] . "</td>";
                if ($innerRow['pay_state'] == 0) {
                    echo "<td style='border: 1px solid lightgreen;'><a href='split-pay-update.php?split_id=$split_id&journey_id=$journey_id&address=" . $innerRow['address'] . "' class='button'>已付款</a></td>";
                } else {
                    echo "<td style='border: 1px solid lightgreen;'><i class=\"fa-solid fa-check\" style=\"color: #FFD43B;\"></i> 已付款</td>";
                }
                echo "<td style='border: 1px solid lightgreen;'><a href='split-del.php?split_id=$split_id&address=" . $innerRow['address'] . "' style='color:red;'>刪除</a></td>";
                echo "<td style='border: 1px solid lightgreen;'><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#split-edit-$split_id-" . urlencode($innerRow['address']) . "'><i class='fa-solid fa-gear' style='color: #ffffff;'></i></button></td>";
                echo "</tr>";


                //inner modal
                echo "<div class='modal fade' id='split-edit-$split_id-" . urlencode($innerRow['address']) . "' tabindex='-1' aria-labelledby='split-edit-$split_id-" . urlencode($innerRow['address']) . "' aria-hidden='true'>";
                echo "<div class='modal-dialog'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<h1 class='modal-title' id='split-edit'>編輯分帳";
                echo "</h1>";
                echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "<form action='split-mem-edit.php' method='post'>";
                echo "<input type='hidden' name='journey_id' value='$journey_id'>";
                echo "<input type='hidden' name='split_id' value='$split_id'>";
                echo "<div style='margin-top: 20px;'>";
                echo "<label for='address'>欠款人:</label><br>";
                echo "<input type='text' id='address' name='address' style=' width:350px;margin: 0 50px;' value='" . $innerRow['address'] . "' readonly><br>";
                echo "</div>";
                echo "<div style='margin-top: 20px;'>";
                echo "<label for='split_amount'>金額:</label><br>";
                echo "<input type='number' id='split_amount' name='split_amount' style=' width:350px;margin: 0 50px;' value='" . $innerRow['split_amount'] . "' required><br>";
                echo "</div>";
                echo "<div style='margin-top: 20px;'>";
                echo "<label for='pay_state'>是否付款:</label><br>";
                echo "<select id='pay_state' name='pay_state' style='width:350px;margin: 0 50px;' required>";
                echo "<option value='1' " . ($innerRow['pay_state'] == 1 ? 'selected' : '') . ">已付款</option>";
                echo "<option value='0' " . ($innerRow['pay_state'] == 0 ? 'selected' : '') . ">未付款</option>";
                echo "</select>";
                echo "</div>";
                echo "<div class='modal-footer' style='display: flex;'>";
                echo "<input type='submit' id='add-journey' class='button' value='編輯' style='width: 500px;'>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }echo "</table>";
    } else {
        echo "<div style='display:flex; justify-content:center; color:white;'><p>查無應收帳款</p></div>";
    }


    $query = "SELECT split_members.split_id, split_members.split_amount, split_members.address, split.split_cate, split.split_date, split.split_note, split_members.pay_state, split.split_payer, account.username
    FROM split_members 
    JOIN split ON split_members.split_id = split.split_id
    JOIN account ON split.split_payer = account.address
              WHERE split.journey_id = '$journey_id' AND split.split_payer != '$address' AND split_members.address = '$address'";
    $result = mysqli_query($link, $query);
    // Check if the query returned any results
    if (mysqli_num_rows($result) > 0) {
        echo "<table id='split-pay-table' style='border-collapse: collapse; display:flex; justify-content:center; color:white; text-align:center;  margin-top:50px;'>";
        echo "<tr style='border: 1px solid white;'>";
        echo "<th style='color:red;'>給</th>";
        echo "<th>應付金額</th>";
        echo "<th>類別</th>";
        echo "<th>日期</th>";
        echo "<th>Note</th>";
        echo "<th>是否付款</th>";
        echo "</tr>";
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td><td>" . $row["split_amount"] . "</td><td>" . $row['split_cate'] . "</td><td>" . $row['split_date'] . "</td><td>" . $row['split_note'] . "</td>";
            if ($row['pay_state'] == 0) {
                echo "<td style='color:red;'>未付款</td>";
            } else {
                echo "<td><i class=\"fa-solid fa-check\" style=\"color: #FFD43B;\"></i>已付款</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div style='display:flex; justify-content:center; color:white;'><p>查無應付帳款</p></div>";
    }
    // Close the connection
    mysqli_close($link);
    ?>



</body>

</html>