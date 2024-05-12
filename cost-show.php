<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        #budget-table td {
            border: 1px solid white;
            width: 150px;
        }

        #budget-table tr {
            height: 50px;
            color: white;
        }

        .btn-primary {
            background-color: transparent;
            border-color: none;
            width: 50px;
            height: 50px;
        }

        .btn-primary:hover {
            background-color: transparent;
            border-color: 1px solid white;
        }
    </style>

    <?php
    session_start(); // Start the session

    // Get the address of the currently logged in user
    $journey_id = $_GET['journey_id'];
    // Connect to the database
    $link = mysqli_connect('localhost', 'root', '12345678', 'travel');

    // Check connection
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Prepare the SQL query



    $query = "SELECT account.address, cost.cost_id, cost.cost_date, cost.cost_cate, cost.cost_amount, cost.cost_note, account.username
    FROM cost
    JOIN journey_members ON cost.address = journey_members.address
    JOIN account ON journey_members.address = account.address
  WHERE cost.journey_id = $journey_id
  GROUP BY cost.cost_id
    ORDER BY cost.cost_date ASC";


    // Execute the query
    $result = mysqli_query($link, $query);

    // Check if the query returned any results
    if (mysqli_num_rows($result) > 0) {
        echo "<table id='budget-table' style='border-collapse: collapse; display:flex; justify-content:center; color:white; text-align:center;'>";
        echo "<tr style='border: 1px solid white;'>";
        echo "<th style='border: 1px solid white;'>花費人</th>";
        echo "<th style='border: 1px solid white;'>日期</th>";
        echo "<th style='border: 1px solid white;'>類別</th>";
        echo "<th style='border: 1px solid white;'>金額</th>";
        echo "<th style='border: 1px solid white;'>紀錄</th>";
        echo "<th style='border: 1px solid white;'>刪除</th>";
        echo "<th style='border: 1px solid white;'>編輯</th>";
        echo "</tr>";
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td><td>" . $row["cost_date"] . "</td><td>" . $row['cost_cate'] . "</td><td>" . $row['cost_amount'] . "</td><td>" . $row['cost_note'] . "</td>";
            echo "<td><a href='cost-del.php?cost_id={$row['cost_id']}&journey_id=$journey_id' style='color:red;'>刪除</a></td>";
            echo "<td><button data-bs-toggle='modal' data-bs-target='#cost-edit-form-{$row['cost_id']}' name='cost-edit' class='btn-primary'><i class='fa-solid fa-gear' style='color: #ffffff;'></i></button></td>";
            echo "</tr>";

            //modal
            echo "<div class='modal fade' id='cost-edit-form-{$row['cost_id']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
            echo "<div class='modal-dialog'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h1 class='modal-title' id='exampleModalLabel'>編輯花費</h1>";
            echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "<form action='cost-edit.php' method='POST'>";
            echo "<input type='hidden' name='cost_id' value='{$row['cost_id']}'>";
            echo "<input type='hidden' name='journey_id' value='$journey_id'>";
            echo "<div class='mb-3'style='margin-top: 20px;'>";
            echo "<label for='cost_date' class='col-form-label'>日期:</label>";
            echo "<input type='date' style=' width:350px;margin: 0 50px;' class='form-control' id='cost_date' name='cost_date' value='{$row['cost_date']}'>";
            echo "</div>";
            echo "<div class='mb-3'style='margin-top: 20px;'>";
            echo "<label for='cost_cate' class='col-form-label'>類別:</label>";
            echo "<select id='cost_cate' name='cost_cate' style='width: 350px; margin: 0 50px;' required>";
            echo "<option value='食物'" . ($row['cost_cate'] == '食物' ? ' selected' : '') . ">食物</option>";
            echo "<option value='交通'" . ($row['cost_cate'] == '交通' ? ' selected' : '') . ">交通</option>";
            echo "<option value='消費'" . ($row['cost_cate'] == '消費' ? ' selected' : '') . ">消費</option>";
            echo "<option value='娛樂'" . ($row['cost_cate'] == '娛樂' ? ' selected' : '') . ">娛樂</option>";
            echo "<option value='住宿'" . ($row['cost_cate'] == '住宿' ? ' selected' : '') . ">住宿</option>";
            echo "<option value='其他'" . ($row['cost_cate'] == '其他' ? ' selected' : '') . ">其他</option>";
            echo "</select><br>";
            echo "</div>";
            echo "<div class='mb-3'style='margin-top: 20px;'>";
            echo "<label for='cost_amount' class='col-form-label'>金額:</label>";
            echo "<input type='text' style=' width:350px;margin: 0 50px;' class='form-control' id='cost_amount' name='cost_amount' value='{$row['cost_amount']}'>";
            echo "</div>";
            echo "<div class='mb-3'style='margin-top: 20px;'>";
            echo "<label for='cost_note' class='col-form-label'>NOTE:</label>";
            echo "<input type='text' style=' width:350px;margin: 0 50px;' class='form-control' id='cost_note' name='cost_note' value='{$row['cost_note']}'>";
            echo "</div>";
            echo "<div class='modal-footer' style='display: flex;'>";
            echo "<input type='submit' id='add-cashflow' class='button' value='儲存' style='width: 500px;'>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</table>";
    } else {
        echo "<div style='display:flex; justify-content:center; color:white;'><p>查無花費資料</p></div>";
    }

    // Close the connection
    mysqli_close($link);
    ?>
</body>

</html>