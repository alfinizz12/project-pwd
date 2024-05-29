<?php
    session_start();

    if(isset($_SESSION['id'])){
        header("Location: home.php");
    }

    include 'functionLogic.php';

    if(isset($_POST['register'])){
        if(register($_POST) > 0){
            header ('Location: login.php');
            exit;
        }
        $err_mess = "Username sudah tersedia atau Password tidak sesuai";
    }

    if(isset($_POST['login'])){
        if(login($_POST["username"], $_POST['password'])){
            $username = $_POST['username'];
            $user = $connection->query("SELECT * FROM user WHERE username = '$username'");
            $user_data = $user->fetch_object();
            $_SESSION['id'] = $user_data->id;
            header('Location: home.php');
            exit;
        }
        $mess = "You input wrong password or username";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="img/iconB.png">
    <title>Log In</title>
</head>

<body class="login-page">
    <div class="wrapper">
        <h1>Bluebuk.</h1>
    </div>
    <div class="login">
        <div class="form-box">
            <div class="button-box">
                <div class="loginback" id="loginback"></div>
                <button type="button" class="topbtn" onclick="login()">Login</button>
                <button type="button" class="topbtn" onclick="register()">Register</button>
            </div>

            <form action="" id="login" method="post" class="box-input">
                <div class="login-title">
                    <h1>Welcome Back!</h1>
                    <p>Nice to see you again</p>
                </div>
                <input type="text" name="username" class="input-field" placeholder="Username" required>
                <input type="password" name="password" class="input-field" id="pass" placeholder="Password" required>
                <!-- <input type="checkbox" class="check" onclick="showpass()">Show Password -->
                <p class="passwrong"><?php if(isset($mess)) echo $mess; ?></p>
                <button type="submit" class="login-button" name="login">Login</button>
            </form>

            <form action="" id="register" method="post" class="box-input"  >
                <div class="register-title">
                    <h1>Hello, Friend!</h1>
                    <p>Let's register</p>
                </div>
                <input type="text" name="username" class="input-field" placeholder="Username" required />
                <input type="email" name="email" class="input-field" placeholder="Email" required />
                <input type="password" name="password" class="input-field" placeholder="Password" required />
                <input type="password" name="password_confirm" class="input-field" placeholder="Confirm Password" required>
                <p class="passwrong"><?php if(isset($err_mess)) echo $err_mess; ?></p>
                <button type="submit" class="login-button" name="register">Register</button>
            </form>
        </div>
    </div>

    <script>
        var x = document.getElementById("login");
        var y = document.getElementById("register");
        var z = document.getElementById("loginback");

        function register() {
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";
        }

        function login() {
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0";
        }

        function showpas() {
            var x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>


</body>

</html>
