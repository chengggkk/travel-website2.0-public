<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['address'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();}
?>


<!DOCTYPE html>
<html>

<head>
    <title>TraSui - Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
                    .intro {
                width: 90%;
                height: 70px;
                background-color: transparent;
                border: white 1px solid;
                border-radius: 50px;
                font-size: 50px;
                transition: background-color 0.3s ease;
                margin: 30px 0;
                /* Add margin top and bottom of 10px */
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .intro:hover {
                background-color: #ffffff;
                color: #000000;
            }
            .address{
                background-color: white;
                border: white 1px solid;
                border-radius: 10px;
                padding: 8px;
                color: black;
                font-size: 16px;
                outline: none;
                transition: border-color 0.3s ease;
            }

            .address:focus {
                border-color: #ffffff;
            }
        form {
            padding: 50px;

        }

        .main-content {
            width: 100%;
            justify-content: center;
            /* Center horizontally */
            color: white;
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

<body>
    <div class="main-content" style="background-image: url(img/griff.jpg);">
        <form action="process_login.php" method="post">
            <div align="center">
                <div>
                    <h2>Login</h2>
                    <label for="address">Address:</label>
                    <input type="text" class="address" id="address" name="address" style="margin-left: 8px;"><br>
                    <div style="margin-top: 30px;">
                        <label for="password">Password:</label>
                        <input class="address" type="password" id="password" name="password"><br>
                    </div>
                    <?php
                    session_start();

                    if (isset($_SESSION['message'])) {
                        echo "<div id='accountno' class='{$_SESSION['msg_type']}' style='color: lightgray;'>{$_SESSION['message']}</div>";
                        unset($_SESSION['message']);
                        unset($_SESSION['msg_type']);
                    }
                    ?>
                </div>
                <div style="margin-top: 50px;">
                    <input class="button" name="login" type="submit" value="登入">
                    <button name="regis" onclick="event.preventDefault(); window.location.href='register.php'">註冊</button>

                </div>
            </div>
        </form>
        <div style="display: flex;">
            <div style="width: 50%; justify-content: center; text-align: center; margin-top:100px; display: flex; flex-direction: column; align-items: center;">
                <p>如何使用?</p>
                <div class="intro"><label>1.註冊</label></div>
                <div class="intro"><label>2.登入</label></div>
                <div class="intro"><label>3.創建旅程</label></div>
                <div class="intro"><label>4.規劃行程</label></div>
            </div>
            <div style="width: 50%; justify-content: center; text-align: center; margin-top:100px; display: flex; flex-direction: column; align-items: center; font-size: 40px;">
                <p>This is some meaningless text.</p>
                <p>Just to fill the space.</p>
                <p>Feel free to replace it with your own content.</p>
            </div>
        </div>
    </div>
</body>

</html>