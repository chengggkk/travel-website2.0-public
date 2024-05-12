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
            width: 200px;
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
    $query = "SELECT budget_id, bud_cate, bud_amount, bud_note FROM budget
          WHERE journey_id = '$journey_id'";
    // Execute the query
    $result = mysqli_query($link, $query);

    // Check if the query returned any results
    if (mysqli_num_rows($result) > 0) {
        echo "<table id='budget-table' style='border-collapse: collapse; display:flex; justify-content:center; color:white; text-align:center;'>";
        echo "<tr style='border: 1px solid white;'>";
        echo "<th style='border: 1px solid white;'>類別</th>";
        echo "<th style='border: 1px solid white;'>金額</th>";
        echo "<th style='border: 1px solid white;'>紀錄</th>";
        echo "<th style='border: 1px solid white;'>刪除</th>";
        echo "<th style='border: 1px solid white;'>編輯</th>";
        echo "</tr>";
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['bud_cate'] . "</td><td>" . $row["bud_amount"] . " </td><td>" . $row['bud_note'] . "</td>";
            echo "<td><a href='budget-del.php?budget_id={$row['budget_id']}&journey_id=$journey_id' style='color:red;'>刪除</a></td>";
            echo "<td><button data-bs-toggle='modal' data-bs-target='#budget-edit-form-{$row['budget_id']}' name='budget-edit' class='btn-primary'><i class='fa-solid fa-gear' style='color: #ffffff;'></i></button></td>";
            echo "</tr>";

            //modal
            echo "<div class='modal fade' id='budget-edit-form-{$row['budget_id']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
            echo "<div class='modal-dialog'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h1 class='modal-title' id='exampleModalLabel'>編輯預算</h1>";
            echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "<form action='budget-edit.php' method='post'>";
            echo "<input type='hidden' name='budget_id' value='{$row['budget_id']}'>";
            echo "<input type='hidden' name='journey_id' value='$journey_id'>";
            echo "<div class='mb-3'style='margin-top: 20px;'>";
            echo "<label for='bud_cate'>類別</label>";
            echo "<select id='bud_cate' name='bud_cate' style='width: 350px; margin: 0 50px;' required>";
            echo "<option value='食物'" . ($row['bud_cate'] == '食物' ? ' selected' : '') . ">食物</option>";
            echo "<option value='交通'" . ($row['bud_cate'] == '交通' ? ' selected' : '') . ">交通</option>";
            echo "<option value='消費'" . ($row['bud_cate'] == '消費' ? ' selected' : '') . ">消費</option>";
            echo "<option value='娛樂'" . ($row['bud_cate'] == '娛樂' ? ' selected' : '') . ">娛樂</option>";
            echo "<option value='住宿'" . ($row['bud_cate'] == '住宿' ? ' selected' : '') . ">住宿</option>";
            echo "<option value='其他'" . ($row['bud_cate'] == '其他' ? ' selected' : '') . ">其他</option>";
            echo "</select><br>";
            echo "</div>";
            echo "<div class='mb-3'style='margin-top: 20px;'>";
            echo "<label for='bud_amount'>金額</label>";
            echo "<input type='text' style=' width:350px;margin: 0 50px;' name='bud_amount' value='{$row['bud_amount']}'><br>";
            echo "</div>";
            echo "<div class='mb-3'style='margin-top: 20px;'>";
            echo "<label for='bud_note'>紀錄</label>";
            echo "<input type='text' style=' width:350px;margin: 0 50px;' name='bud_note' value='{$row['bud_note']}'><br>";
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
        echo "<div style='display:flex; justify-content:center; color:white;'><p>查無預算資料</p></div>";
    }

    // Close the connection
    mysqli_close($link);
    ?>
</body>

</html>