<!-- register.php -->
<?php
session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Register Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .address {
            background-color: white;
            border: gray 1px solid;
            border-radius: 10px;
            padding: 8px;
            color: black;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
            width: 500px;
        }

        .address:focus {
            border-color: #ffffff;
        }

        form {
            padding: 50px;
            background-color: white;
            border-radius: 50px;
            opacity: 0.9;
        }
        input {
            margin: 10px 0;
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            color: black;
        }

        button {
            width: 100px;
            height: 50px;
            background-color: black;
            color: white;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ffffff;
            color: #000000;
        }

    </style>
</head>

<body style="background-image: url(img/griday.jpg);overflow:hidden;">
    <div class="main-content" style=" display: flex; justify-content: center; align-items: center;">
        <form action="process_reg.php" method="post">
            <h1 align="center">註冊</h1>
            <label for="address">Address:</label>
            <input class="address" style="margin-left: 20px;" type="text" id="address" name="address"><br>
            <label style="margin-left: -3px;" for="password">Password:</label>
            <input class="address" style="margin-left: 15px;" type="password" id="password" name="password"><br>
            <label style="margin-left: 1px;" for="name">Name:</label>
            <input class="address" style="margin-left: 36px;" type="text" id="name" name="name"><br>
            <label style="margin-left: 3px;" for="email">Email:</label>
            <input class="address" style="margin-left: 35px;" type="email" id="email" name="email"><br>            <?php if (isset($_SESSION['message'])) {
                // Display the message
                echo "<div class='{$_SESSION['msg_type']}' style='color: red; text-align: center;'>{$_SESSION['message']}</div>";

                // Unset the message
                unset($_SESSION['message']);
                unset($_SESSION['msg_type']);
            }  ?>
            <div style="display: flex; justify-content: center;">
                <input style="margin-top: 20px;" id="regis-check" class="button" type="submit" value="註冊帳號">
            </div>
        </form>
    </div>
</body>

</html>