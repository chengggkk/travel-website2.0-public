<?php
session_start();

if (isset($_SESSION['message'])) {
    // Display the message
    echo "<script>alert('{$_SESSION['message']}');</script>";

    // Unset the message
    unset($_SESSION['message']);
    unset($_SESSION['status']);
}
$journey_id = $_GET['journey_id'];

?>
<style>
    .arr_form {
        background-color: transparent;
        display: flex;
        color: white;
    }



    .arrtable {
        color: white;
        width: 100%;
    }

    .arrtable th,
    .arrtable td,
    .arrtable tr {
        border: 1px solid white;
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Search for adding locations
    $(document).ready(function() {
        $('.search-location').on('input', function() {
            var searchQuery = $(this).val();
            if (searchQuery) {
                $.ajax({
                    url: 'search-location.php',
                    type: 'POST',
                    data: {
                        query: searchQuery
                    },
                    success: function(data) {
                        $('#search-location').html(data);
                        // Add a link to add-location.php at the top
                        $('#search-location').append('<a href="add-location.php" class="search-item" style="display:block; height:40px; margin-top:10px;">新增景點</a>');
                        $('#search-location').show();
                    }
                });
            } else {
                $('#search-location').html('');
                $('#search-location').hide();
            }
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-space').length) {
                $('#search-location').hide();
            }
        });

        $('#search-location').on('click', 'a', function(e) {
            if ($(this).attr('href') !== 'add-location.php') {
                e.preventDefault();
                var selectedLocationName = $(this).text().trim();
                var selectedLocationId = $(this).data('location-id'); // Extract the location_id
                $('.search-location').val(selectedLocationName);
                $('#location_id').val(selectedLocationId); // Save the location_id in the hidden input field
                $('#search-location').hide();
            }
        });
    });



    $(document).ready(function() {
        // Search for editing locations
        $('.search-location-edit').on('input', function() { // 修改此处的类名为 search-location-edit
            var searchQuery = $(this).val();
            if (searchQuery) {
                $.ajax({
                    url: 'search-edit.php',
                    type: 'POST',
                    data: {
                        query: searchQuery
                    },
                    success: function(data) {
                        $('#edit-search-location').html(data); // 修改此处的 ID 为 edit-search-location
                        $('#edit-search-location').append('<a href="add-location.php" class="search-item" style="display:block; width:200px; height:40px; margin-top:10px;z-index:1001;">新增景點</a>'); // 修改此处的 ID 为 edit-search-location
                        $('#edit-search-location').show(); // 修改此处的 ID 为 edit-search-location
                    }
                });
            } else {
                $('#edit-search-location').html(''); // 修改此处的 ID 为 edit-search-location
                $('#edit-search-location').hide(); // 修改此处的 ID 为 edit-search-location
            }
        });

        // Add event listener to close search results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-space-edit').length) {
                $('#edit-search-location').hide(); // 修改此处的 ID 为 edit-search-location
            }
        });

        // Handle click on search result
        $('#edit-search-location').on('click', 'a', function(e) {
            if ($(this).attr('href') !== 'add-location.php') {
                e.preventDefault();
                var selectedLocationName = $(this).text().trim();
                var selectedLocationId = $(this).data('edit-location-id');
                $('.search-location-edit').val(selectedLocationName);
                $('#edit-location_id').val(selectedLocationId);
                $('#edit-search-location').hide();
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <link rel='stylesheet' href='modal.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div style="display: flex; justify-content: center;">
        <form class="arr_form" action="process_arr.php" method="post">
            <input type="hidden" id="location_id" name="location_id">
            <input type="hidden" name="journey_id" value="<?php echo $journey_id; ?>">
            <label for="arr_date">Arrange Date:</label><br>
            <input type="date" id="arr_date" name="arr_date" min="<?php echo $start_date ?>" max="<?php echo $end_date ?>" required><br>
            <label for="arr_time">Arrange Time:</label><br>
            <input type="time" id="arr_time" name="arr_time"><br>
            <label for="arr_locate">Arrange Location:</label><br>
            <div class="search-space" style="position: relative; z-index: 1000;">
                <input type="text" id=search style="height:50px; color:black; width:550px;" id="location_name" class="search-location" placeholder="搜尋景點">
                <div id="search-location" style="color:black; position: absolute; background: white; border-radius: 10px; width:550px;"></div>
            </div>
            <input style="margin-left:10px;" name="submit" class="button" type="submit" value="新增行程">
        </form>
    </div>

    <!-- Display existing arrangements -->
    <?php
    // Connect to the database
    $link = mysqli_connect('localhost', 'root', '12345678', 'travel');

    // Check connection
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve existing arrangements for the journey_id
    $sql = "SELECT * FROM arrangement WHERE journey_id = $journey_id ORDER BY arr_date ASC";
    $result = mysqli_query($link, $sql);

    // Display arrangements in a table
    echo "<table class='arrtable'  align='center'>";
    echo "<tr>";
    echo "<th>日期</th>";
    echo "<th>時間</th>";
    echo "<th>景點名稱</th>";
    echo "<th>地址</th>";
    echo "<th>刪除</th>";
    echo "<th>編輯</th>";
    echo "</tr>";

    // Fetch and display each arrangement
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['arr_date'] . "</td>";
        echo "<td>" . $row['arr_time'] . "</td>";
        // Fetch and display location details based on location_id
        $location_id = $row['location_id'];
        $sql_location = "SELECT loca_name, loca_address FROM location WHERE location_id = $location_id";
        $result_location = mysqli_query($link, $sql_location);
        $row_location = mysqli_fetch_assoc($result_location);
        echo "<td>" . $row_location['loca_name'] . "</td>";
        echo "<td><a style='color:white;' href='search_result.php?location_id={$row['location_id']}'>" . $row_location['loca_address'] . "</a></td>";
        echo "<td style='text-align:center;'><a style='color:red;' href='delete_arr.php?arr_id={$row['arrange_id']}&journey_id={$journey_id}'>Delete</a></td>";
        echo '<td style="text-align:center;"><button type="button" class="btn btn-primary edit-arr" data-bs-toggle="modal" data-bs-target="#edit-arr" 
        data-arr-id="' . $row['arrange_id'] . '" data-arr-date="' . $row['arr_date'] . '" data-arr-time="' . $row['arr_time'] . '" data-arr-loca-id="' . $row['location_id'] . '" data-arr-loca-name="' . $row_location['loca_name']  . '">
            <i class=\'fi fi-rr-edit\'></i></button></td>';
        echo "</tr>";
    }
    echo "</table>";

    // Close the database connection
    mysqli_close($link);
    ?>
    <!-- Modal -->
    <div class="modal fade" id="edit-arr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">編輯行程</h1>
                    <button type="button" id="edit-arr" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="width: 30px; height: 30px;"><i class="fi fi-rr-cross-small"></i></button>
                </div>
                <div class="modal-body">
                    <form class="edit-arr-form" action="edit-arr.php" method="post">
                        <input type="hidden" id="edit-arr_id" name="arr_id">
                        <input type="hidden" id="edit-location_id" name="edit-location_id">
                        <input type="hidden" name="journey_id" value="<?php echo $journey_id; ?>">
                        <div style="display: flex; justify-content: center;">
                            <label for="edit-arr_date">Arrange Date:</label><br> <!-- 修改此处的 ID 为 edit-arr_date -->
                            <input type="date" id="edit-arr_date" name="arr_date" min="<?php echo $start_date ?>" max="<?php echo $end_date ?>" required><br>
                            <label for="edit-arr_time">Arrange Time:</label><br> <!-- 修改此处的 ID 为 edit-arr_time -->
                            <input type="time" id="edit-arr_time" name="arr_time"><br>
                        </div>
                        <div style="display: flex; justify-content: center; margin-top:50px;">
                            <label for="edit-arr_locate">Arrange Location:</label><br> <!-- 修改此处的 ID 为 edit-arr_locate -->
                            <div class="search-space-edit" style="position: relative; z-index: 1000;">
                                <input type="text" id="edit-search" style="height:50px; color:black;" class="search-location-edit" placeholder="Search for location">
                                <div id="edit-search-location" style="color:black; position: absolute; background: white; border-radius: 10px;"></div>
                            </div>
                        </div>
                        <div class="modal-footer" style="height: 25px;">
                            <input type="submit" class="button" value="儲存編輯">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<script>
    $(document).ready(function() {
        $('.edit-arr').on('click', function() {
            var arrId = $(this).data('arr-id');
            var arrDate = $(this).data('arr-date');
            var arrTime = $(this).data('arr-time');
            var arrLocate = $(this).data('arr-loca-id');
            var arrLocateName = $(this).data('arr-loca-name');

            $('#edit-arr_id').val(arrId);
            $('#edit-arr_date').val(arrDate);
            $('#edit-arr_time').val(arrTime);
            $('#edit-search').val(arrLocateName); // Set the search input value to the loca_name
            $('#edit-location_id').val(arrLocate); // Set the hidden input value to the location_id
        });
    });
</script>