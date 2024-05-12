

<style>
    #fribtn,
    #userbtn {
        background-color: #333333;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        height: 50px   ;
    }

    #fri-content{
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        width: 250px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    #user-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    #fri-content a,
    #user-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    #fri-content a:hover,
    #user-content a:hover {
        background-color: #f1f1f1;
    }


    #fridropdown,
    #user {
        position: relative;
    }

    #fri-content,
    #user-content {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- navbar.php -->
    <?php
    session_start();
    $username = $_SESSION['username'] ?? ''; // Get the name from the session
    ?>
    <script src="https://kit.fontawesome.com/29a6af0e63.js" crossorigin="anonymous"></script>

    <nav style="display: flex; justify-content: space-between; align-items: center;">
        <a href="index.php"><img src="img/logo.png" alt="Logo" style="width:100px; height: 50px;"></a>

        <div class="search-space" style="position: relative; z-index: 1001;">
            <i class="fa-solid fa-magnifying-glass fa-lg" style="color: #ffffff;"></i>
            <input type="text" style="width: 1000px;height:35px; color:white;" class="search" placeholder="搜尋景點">
            <div id="search-results" style="margin-left:25px; position: absolute; width: 1000px; background: white; border-radius: 10px;"></div>
        </div>

        <div style="display: flex;z-index: 1001;">
            <div id="fridropdown" style="margin-right:5px;">
                <button id="fribtn">顯示好友</button>
                <div id="fri-content">
                    <?php include 'friend.php' ?>
                </div>
            </div>

            <div id="user">
                <button id="userbtn"><?php echo $username; ?></button>
                <div id="user-content">
                    <a href="logout.php">log out</a>
                </div>
            </div>
        </div>
    </nav>


</body>

</html>
<script>
    $(document).ready(function() {
        $('.search').on('input', function() {
            var searchQuery = $(this).val();
            if (searchQuery) {
                $.ajax({
                    url: 'search.php',
                    type: 'POST',
                    data: {
                        query: searchQuery
                    },
                    success: function(data) {
                        $('#search-results').html('<a href="add-location.php" class="search-item" style="display:block; height:40px; margin-top:10px;">新增景點</a>' + data);
                    }
                });
            } else {
                $('#search-results').html('');
            }
        });
        $('#search').on('click', 'a', function(e) {
            // Check if the clicked anchor tag does not link to add-location.php
            if ($(this).attr('href') !== 'add-location.php') {
                e.preventDefault();
                var selectedLocationName = $(this).text().trim();
                var selectedLocationAddress = $(this).find('span').text();
                $('.search').val(selectedLocationName + " - " + selectedLocationAddress);
                $('#search').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#userbtn').click(function(e) {
            e.stopPropagation(); // Stop event propagation
            $('#user-content').slideToggle();
        });

        $('#fribtn').click(function(e) {
            e.stopPropagation(); // Stop event propagation
            $('#fri-content').slideToggle();
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('#user, #fridropdown').length) {
                $('#user-content, #fri-content').slideUp();
            }
        });
    });
</script>