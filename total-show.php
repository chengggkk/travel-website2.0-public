<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #budget-table td {
            border: 1px solid white;
            width: 95px;
        }

        #budget-table tr {
            height: 50px;
            color: white;
        }

        #budget-table th {
            height: 50px;
            color: white;
            width: 300px;
        }
    </style>
</head>



<body>
    <div style="display: flex;">
        <div style=" margin-top:80px;">
            <?php
            session_start();
            $address = $_SESSION['address'];
            // Connect to your database. Replace with your connection details
            $mysqli = new mysqli('localhost', 'root', '12345678', 'travel');
            // Assuming $mysqli is your database connection
            $categories = ['食物', '交通', '消費', '娛樂', '住宿', '其他'];
            $journey_id = $_GET['journey_id'];
            $cost_totals = [];

            foreach ($categories as $category) {
                $query = "SELECT cost.journey_id, sum(cost.cost_amount) as cost_total, cost.cost_cate
    FROM cost
    WHERE cost.journey_id=$journey_id AND cost_cate='$category'";

                $result = $mysqli->query($query);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $cost_totals[$category] = $row["cost_total"];
                    }
                } else {
                    $cost_totals[$category] = 0;
                }
            }
            $cost_total = ($cost_totals['食物'] + $cost_totals['交通'] + $cost_totals['消費'] + $cost_totals['娛樂'] + $cost_totals['住宿'] + $cost_totals['其他']) ?? 0;

            $split_totals = [];

            foreach ($categories as $category) {
                $query = "SELECT split.journey_id, sum(split_members.split_amount) as split_total, split.split_cate
    FROM split
    JOIN split_members on split.split_id = split_members.split_id
    WHERE split.journey_id=$journey_id AND split_cate='$category'";

                $result = $mysqli->query($query);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $split_totals[$category] = $row["split_total"]; // Changed from cost_total to split_total
                    }
                } else {
                    $split_totals[$category] = 0;
                }
            }
            $split_total = ($split_totals['食物'] + $split_totals['交通'] + $split_totals['消費'] + $split_totals['娛樂'] + $split_totals['住宿'] + $split_totals['其他']) ?? 0;

            $user_cost_totals = [];
            foreach ($categories as $category) {
                $query = "SELECT journey_id, sum(cost_amount) as cost_total, cost_cate
                FROM cost
                WHERE journey_id=$journey_id AND cost_cate='$category' AND address='$address'";

                $result = $mysqli->query($query);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $user_cost_totals[$category] = $row["cost_total"]; // Corrected from user_cost_total to cost_total
                    }
                } else {
                    $user_cost_totals[$category] = 0;
                }
            }
            $user_cost_total = ($user_cost_totals['食物'] + $user_cost_totals['交通'] + $user_cost_totals['消費'] + $user_cost_totals['娛樂'] + $user_cost_totals['住宿'] + $user_cost_totals['其他']) ?? 0;

            $user_split_totals = [];

            foreach ($categories as $category) {
                $query = "SELECT split.journey_id, sum(split_members.split_amount) as split_total, split.split_cate
    FROM split
    JOIN split_members on split.split_id = split_members.split_id
    WHERE split.journey_id=$journey_id AND split_cate='$category' AND split_members.address='$address'";

                $result = $mysqli->query($query);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $user_split_totals[$category] = $row["split_total"]; // Changed from cost_total to split_total
                    }
                } else {
                    $user_split_totals[$category] = 0;
                }
            }
            $user_split_total = ($user_split_totals['食物'] + $user_split_totals['交通'] + $user_split_totals['消費'] + $user_split_totals['娛樂'] + $user_split_totals['住宿'] + $user_split_totals['其他']) ?? 0;

            echo "<div style='display: flex;'>";
            if ($cost_total + $split_total == 0) {
                echo "<h1 style='color:white;margin-right:500px;'>團隊尚無開支</h1>";
            } else echo "
            <div style='width: 50%; height:50%; margin-top:30px;'>
                <h2 style='color:white;'>團隊開支圖表</h2>
                <canvas id='total-chart'></canvas>
            </div>";

            if (($user_cost_total + $user_split_total) == 0) {
                echo "<h1 style='color:white;'>個人尚無開支</h1>";
            } else echo "
            <div style='width: 50%; height:50%; margin-top:30px;'>
                <h2 style='color:white;'>個人開支圖表</h2>
                <canvas id='user-total-chart'></canvas>
            </div>";
            echo "</div>";


            // Now you can access the totals like this:
            echo "<h1 style='color:white;'>團隊預算/花費</h1>";
            echo "<table id='budget-table' style='border-collapse: collapse; display:flex; justify-content:center; color:white; text-align:center;'>";
            echo "<tr><th>項目/類別</th><th>食物</th><th>交通</th><th>消費</th><th>娛樂</th><th>住宿</th><th>其他</th><th>總金額</th></tr>";
            echo "<tr>";
            echo "<td><i class='fa-solid fa-coins' style='color: #FFD43B; margin-right:5px;'></i>花費</td>";
            echo "<td>" . ($cost_totals['食物'] ?? 0) . "</td>";
            echo "<td>" . ($cost_totals['交通'] ?? 0) . "</td>";
            echo "<td>" . ($cost_totals['消費'] ?? 0) . "</td>";
            echo "<td>" . ($cost_totals['娛樂'] ?? 0) . "</td>";
            echo "<td>" . ($cost_totals['住宿'] ?? 0) . "</td>";
            echo "<td>" . ($cost_totals['其他'] ?? 0) . "</td>";
            echo "<td>" . $cost_total . "</td>";
            echo "</tr>";


            echo "<tr>";
            echo "<td><i class='fa-solid fa-wallet' style='color: #63E6BE; margin-right:5px;'></i>分帳</td>";
            echo "<td>" . ($split_totals['食物'] ?? 0) . "</td>";
            echo "<td>" . ($split_totals['交通'] ?? 0) . "</td>";
            echo "<td>" . ($split_totals['消費'] ?? 0) . "</td>";
            echo "<td>" . ($split_totals['娛樂'] ?? 0) . "</td>";
            echo "<td>" . ($split_totals['住宿'] ?? 0) . "</td>";
            echo "<td>" . ($split_totals['其他'] ?? 0) . "</td>";
            echo "<td>" . $split_total . "</td>";


            $totals = [];
            foreach ($categories as $category) {
                $totals[$category] = ($cost_totals[$category] ?? 0) + ($split_totals[$category] ?? 0);
            }
            echo "<tr>";
            echo "<td>總金額</td>";
            echo "<td>" . ($totals['食物'] ?? 0) . "</td>";
            echo "<td>" . ($totals['交通'] ?? 0) . "</td>";
            echo "<td>" . ($totals['消費'] ?? 0) . "</td>";
            echo "<td>" . ($totals['娛樂'] ?? 0) . "</td>";
            echo "<td>" . ($totals['住宿'] ?? 0) . "</td>";
            echo "<td>" . ($totals['其他'] ?? 0) . "</td>";
            echo "<td>" . ($cost_total + $split_total) . "</td>";
            echo "</tr>";
            echo "</table>";

            $budget_totals = [];

            foreach ($categories as $category) {
                $query = "SELECT budget.journey_id, sum(budget.bud_amount) as budget_total, budget.bud_cate
            FROM budget
            WHERE budget.journey_id=$journey_id AND budget.bud_cate='$category'"; // Corrected the column name from budget_cate to bud_cate

                $result = $mysqli->query($query);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $budget_totals[$category] = $row["budget_total"];
                    }
                } else {
                    $budget_totals[$category] = 0;
                }
            }

            // Now you can display the budget totals
            echo "<table id='budget-table' style='border-collapse: collapse; display:flex; justify-content:center; color:white; text-align:center; margin-top:50px;'>";
            echo "<tr><th>項目</th><th>食物</th><th>交通</th><th>消費</th><th>娛樂</th><th>住宿</th><th>其他</th><th>總預算</th></tr>";
            echo "<tr>";
            echo "<td><i class='fa-solid fa-sack-dollar' style='color: #FFD43B; margin-right:5px;'></i>預算</td>";
            echo "<td>" . ($budget_totals['食物'] ?? 0) . "</td>";
            echo "<td>" . ($budget_totals['交通'] ?? 0) . "</td>";
            echo "<td>" . ($budget_totals['消費'] ?? 0) . "</td>";
            echo "<td>" . ($budget_totals['娛樂'] ?? 0) . "</td>";
            echo "<td>" . ($budget_totals['住宿'] ?? 0) . "</td>";
            echo "<td>" . ($budget_totals['其他'] ?? 0) . "</td>";
            echo "<td>" . $budget_total = ($budget_totals['食物'] + $budget_totals['交通'] + $budget_totals['消費'] + $budget_totals['娛樂'] + $budget_totals['住宿'] + $budget_totals['其他']) . "</td>";
            echo "</tr>";
            echo "</table>";

            $query = "SELECT cashflow_id, sum(cashflow_amount) as cashflow_total, from_address
            FROM cashflow
            WHERE journey_id=$journey_id AND from_address='$address'"; // Corrected the column name from budget_cate to bud_cate

            $result = $mysqli->query($query);
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $cashflow_pay_totals = $row["cashflow_total"];
                }
            } else {
                $cashflow_pay_totals = 0;
            }

            $query = "SELECT cashflow_id, sum(cashflow_amount) as cashflow_total, to_address
            FROM cashflow
            WHERE journey_id=$journey_id AND to_address='$address'"; // Corrected the column name from budget_cate to bud_cate

            $result = $mysqli->query($query);
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $cashflow_receive_totals = $row["cashflow_total"];
                }
            } else {
                $cashflow_receive_totals = 0;
            }

            $cashflow_total = ($cashflow_pay_totals - $cashflow_receive_totals);


            echo "<h1 style='color:white;'>個人開支</h1>";
            echo "<table id='budget-table' style='border-collapse: collapse; display:flex; justify-content:center; color:white; text-align:center;'>";
            echo "<tr><th style='width:400px;'><i class='fa-regular fa-money-bill-1' style='color: #FFD43B; margin-right:5px;'></i>金流</th><th style='width:400px;'>支出</th><th>收入</th><th style='width:400px;'>總支出/收入</th></tr>";
            echo "<tr>";
            echo "<td>金額</td>";
            echo "<td>" . ($cashflow_pay_totals ?? 0) . "</td>";
            echo "<td>" . ($cashflow_receive_totals ?? 0) . "</td>";
            if ($cashflow_total < 0) {
                echo "<td style='color:lightgreen'>" . (-$cashflow_total) . "</td>";
            } else {
                echo "<td style='color:red'>-" . $cashflow_total . "</td>";
            }
            echo "</tr>";
            echo "</table>";

            echo "<table id='budget-table' style='border-collapse: collapse; display:flex; justify-content:center; color:white; text-align:center; margin-top:50px;'>";
            echo "<tr><th>項目/類別</th><th>食物</th><th>交通</th><th>消費</th><th>娛樂</th><th>住宿</th><th>其他</th><th>總金額</th></tr>";
            echo "<tr>";
            echo "<td><i class='fa-solid fa-coins' style='color: #FFD43B; margin-right:5px;'></i>花費</td>";
            echo "<td>" . ($user_cost_totals['食物'] ?? 0) . "</td>";
            echo "<td>" . ($user_cost_totals['交通'] ?? 0) . "</td>";
            echo "<td>" . ($user_cost_totals['消費'] ?? 0) . "</td>";
            echo "<td>" . ($user_cost_totals['娛樂'] ?? 0) . "</td>";
            echo "<td>" . ($user_cost_totals['住宿'] ?? 0) . "</td>";
            echo "<td>" . ($user_cost_totals['其他'] ?? 0) . "</td>";
            echo "<td>" . $user_cost_total = ($user_cost_totals['食物'] + $user_cost_totals['交通'] + $user_cost_totals['消費'] + $user_cost_totals['娛樂'] + $user_cost_totals['住宿'] + $user_cost_totals['其他']) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><i class='fa-solid fa-wallet' style='color: #63E6BE; margin-right:5px;'></i>分帳</td>";
            echo "<td>" . ($user_split_totals['食物'] ?? 0) . "</td>";
            echo "<td>" . ($user_split_totals['交通'] ?? 0) . "</td>";
            echo "<td>" . ($user_split_totals['消費'] ?? 0) . "</td>";
            echo "<td>" . ($user_split_totals['娛樂'] ?? 0) . "</td>";
            echo "<td>" . ($user_split_totals['住宿'] ?? 0) . "</td>";
            echo "<td>" . ($user_split_totals['其他'] ?? 0) . "</td>";
            echo "<td>" . $user_split_total = ($user_split_totals['食物'] + $user_split_totals['交通'] + $user_split_totals['消費'] + $user_split_totals['娛樂'] + $user_split_totals['住宿'] + $user_split_totals['其他']) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>總金額</td>";
            echo "<td>" . (($user_cost_totals['食物'] ?? 0) + ($user_split_totals['食物'] ?? 0)) . "</td>";
            echo "<td>" . (($user_cost_totals['交通'] ?? 0) + ($user_split_totals['交通'] ?? 0)) . "</td>";
            echo "<td>" . (($user_cost_totals['消費'] ?? 0) + ($user_split_totals['消費'] ?? 0)) . "</td>";
            echo "<td>" . (($user_cost_totals['娛樂'] ?? 0) + ($user_split_totals['娛樂'] ?? 0)) . "</td>";
            echo "<td>" . (($user_cost_totals['住宿'] ?? 0) + ($user_split_totals['住宿'] ?? 0)) . "</td>";
            echo "<td>" . (($user_cost_totals['其他'] ?? 0) + ($user_split_totals['其他'] ?? 0)) . "</td>";
            echo "<td>" . ($user_cost_total + $user_split_total) . "</td>";
            echo "</tr>";
            echo "</table>";
            ?>
        </div>

    </div>
</body>

</html>
<script>
    const ctx = document.getElementById('total-chart');
    Chart.defaults.color = '#FFFFFF';
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['食物', '交通', '消費', '娛樂', '住宿', '其他'],
            datasets: [{
                label: '總金額',
                data: [<?php echo $totals['食物']; ?>, <?php echo $totals['交通']; ?>, <?php echo $totals['消費']; ?>, <?php echo $totals['娛樂']; ?>, <?php echo $totals['住宿']; ?>, <?php echo $totals['其他']; ?>],
                borderWidth: 1
            }]
        },
    });

    const chart = document.getElementById('user-total-chart');
    Chart.defaults.color = '#FFFFFF';
    new Chart(chart, {
        type: 'doughnut',
        data: {
            labels: ['食物', '交通', '消費', '娛樂', '住宿', '其他'],
            datasets: [{
                label: '總金額',
                data: [<?php echo (($user_cost_totals['食物'] ?? 0) + ($user_split_totals['食物'] ?? 0)); ?>,
                    <?php echo (($user_cost_totals['交通'] ?? 0) + ($user_split_totals['交通'] ?? 0)); ?>,
                    <?php echo (($user_cost_totals['消費'] ?? 0) + ($user_split_totals['消費'] ?? 0)); ?>,
                    <?php echo (($user_cost_totals['娛樂'] ?? 0) + ($user_split_totals['娛樂'] ?? 0)); ?>,
                    <?php echo (($user_cost_totals['住宿'] ?? 0) + ($user_split_totals['住宿'] ?? 0)); ?>,
                    <?php echo (($user_cost_totals['其他'] ?? 0) + ($user_split_totals['其他'] ?? 0)); ?>
                ],
                borderWidth: 1
            }]
        },
    });
</script>