<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
    <link rel="stylesheet" href="modal.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <?php
    // Get the journey_id of the currently selected journey
    $journey_id = $_GET['journey_id'];
    // Connect to the database
    $link = mysqli_connect('localhost', 'root', '12345678', 'travel');

    // Check connection
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Prepare the SQL query
    $query = "SELECT
    cashflow.cashflow_id,
    cashflow.journey_id,
    cashflow.from_address, 
    cashflow.to_address, 
    cashflow.cashflow_date, 
    cashflow.cashflow_amount, 
    cashflow.cashflow_note,
    GROUP_CONCAT(distinct from_account.username) AS from_username,
    GROUP_CONCAT(distinct to_account.username) AS to_username
FROM 
    cashflow
JOIN 
    journey_members from_journey_members ON cashflow.from_address = from_journey_members.address
JOIN 
    account from_account ON from_journey_members.address = from_account.address
JOIN 
    journey_members to_journey_members ON cashflow.to_address = to_journey_members.address
JOIN 
    account to_account ON to_journey_members.address = to_account.address
WHERE 
    cashflow.journey_id = $journey_id
GROUP BY
    cashflow.cashflow_id";
    // Execute the query
    $result = mysqli_query($link, $query);

    // Check if the query returned any results
    if (mysqli_num_rows($result) > 0) {
        echo "<table id='budget-table' style='border-collapse: collapse; display:flex; justify-content:center; color:white;text-align:center;'>";
        echo "<tr style='border: 1px solid white;'>";
        echo "<th style='border: 1px solid white;'>從</th>";
        echo "<th style='border: 1px solid white;'>給</th>";
        echo "<th style='border: 1px solid white;'>日期</th>";
        echo "<th style='border: 1px solid white;'>金額</th>";
        echo "<th style='border: 1px solid white;'>Note</th>";
        echo "<th style='border: 1px solid white;'>刪除</th>";
        echo "<th style='border: 1px solid white;'>編輯</th>";
        echo "</tr>";
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['from_username'] . "</td><td>" . $row['to_username'] . "</td><td>" . $row["cashflow_date"] . "</td><td>" . $row['cashflow_amount'] . "</td><td>" . $row['cashflow_note'] . "</td>";
            echo "<td><a href='cashflow-del.php?cashflow_id={$row['cashflow_id']}&journey_id=$journey_id' style='color:red;'>刪除</a></td>";
            echo "<td><button data-bs-toggle='modal' data-bs-target='#cashflow-edit-form-{$row['cashflow_id']}' name='cashflow-edit' class='btn-primary'><i class='fa-solid fa-gear' style='color: #ffffff;'></i></button></td>";
            echo "</tr>";
            $cashflow_date = $row["cashflow_date"];
            $cashflow_amount = $row['cashflow_amount'];
            $cashflow_note = $row['cashflow_note'];
            $from_address = $row['from_address'];
            $to_address = $row['to_address'];
            //modal
            echo "<div class='modal fade' id='cashflow-edit-form-{$row['cashflow_id']}' tabindex='-1' aria-labelledby='cashflow-edit-form-{$row['cashflow_id']}' aria-hidden='true'>";
            echo "<div class='modal-dialog'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h1 class='modal-title' id='cashflow-edit'>編輯金流</h1>";
            echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'style='width:25px; height:25px;'><i class='fa-solid fa-xmark' ></i></button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "<form action='cashflow-edit.php' method='post'>";
            echo "<input type='hidden' name='cashflow_id' value='{$row['cashflow_id']}'>";
            echo "<input type='hidden' name='journey_id' value='{$row['journey_id']}'>";
            echo "<div style='margin-top: 20px;'>";
            echo "<label for='to_address'>From:</label><br><select id='from_address' name='from_address' style=' width:350px;margin: 0 50px;' required>";

            $innerquery = "SELECT account.username, account.address FROM account 
                                JOIN journey_members ON account.address = journey_members.address
                                WHERE journey_members.journey_id = $journey_id";
            $innerresult = mysqli_query($link, $innerquery);
            while ($row = mysqli_fetch_assoc($innerresult)) {
                $selected = $row['address'] == $from_address ? 'selected' : '';
                echo "<option value='" . $row['address'] . "' $selected>" . $row['username'] . "</option>";
            }

            echo "</select><br>";
            echo "</div>";
            echo "<div style='margin-top: 20px;'>";
            echo "<label for='from_address'>To:</label><br><select id='to_address' name='to_address' style=' width:350px;margin: 0 50px;' required>";

            $innerquery = "SELECT account.username, account.address FROM account 
                                JOIN journey_members ON account.address = journey_members.address
                                WHERE journey_members.journey_id = $journey_id";
            $innerresult = mysqli_query($link, $innerquery);
            while ($row = mysqli_fetch_assoc($innerresult)) {
                $selected = $row['address'] == $to_address ? 'selected' : '';
                echo "<option value='" . $row['address'] . "' $selected>" . $row['username'] . "</option>";
            }
            echo "</select><br>";
            echo "</div>";
            echo "<div style='margin-top: 20px;'>";
            echo "<label for='cashflow_date'>日期:</label><br>";
            echo "<input type='date' id='cashflow_date' name='cashflow_date' style=' width:350px;margin: 0 50px;' value='{$cashflow_date}' required><br>";
            echo "</div>";
            echo "<div style='margin-top: 20px;'>";
            echo "<label for='cashflow_amount'>金額:</label><br>";
            echo "<input type='text' id='cashflow_amount' name='cashflow_amount' style=' width:350px;margin: 0 50px;' value='{$cashflow_amount}' required><br>";
            echo "</div>";
            echo "<div style='margin-top: 20px;'>";
            echo "<label for='cashflow_note'>Note:</label><br>";
            echo "<input type='text' id='cashflow_note' name='cashflow_note' style=' width:350px;margin: 0 50px;' value='{$cashflow_note}' required><br>";
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
        echo "<div style='display:flex; justify-content:center; color:white;'><p>查無金流資料</p></div>";
    }

    // Close the connection
    mysqli_close($link);
    ?>


</body>

</html>