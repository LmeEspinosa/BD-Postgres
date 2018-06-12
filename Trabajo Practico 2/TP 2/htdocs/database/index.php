<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style/index_style.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    </head>
    <body>
        <div class="form-container">
            <h1 class="main-title">DATABASE II TP II</h1>
            <form id="login" class="form-wrapper" action="login/login.php" method="post"> 
                <h2 class="form-title">Login</h2>
                <input type="text" name="user" placeholder="UserName" class="input-element" required>
                <input type="password" name="password" placeholder="Password" class="input-element" required>
                <button type="submit" class="btn-element">Sing In</button>
                <h3 class="message"><span id="register-link">Register</span> or <span id="password-link">Change Password</span></h3>
            </form>
            <form id="register" class="form-wrapper" action="login/register.php" method="post"> 
                <h2 class="form-title">Create Account</h2>
                <input type="text" name="name" placeholder="Name" class="input-element" required>
                <input type="text" name="surname" placeholder="Surname" class="input-element" required>
                <input type="text" name="user" placeholder="UserName" class="input-element" required>
                <input type="password" name="password" placeholder="Password" class="input-element" required>
                <button type="submit" class="btn-element">Register</button>
                <h3 class="message"><span id="login-link">Log In</span> or <span id="password-link2">Change Password</span></h3>
            </form>
            <form id="password-change" class="form-wrapper" action="login/changepsw.php" method="post"> 
                <h2 class="form-title">Change Password</h2>
                <input type="text" name="user" placeholder="UserName" class="input-element" required>
                <input type="password" name="password" placeholder="OLD Password" class="input-element" required>
                <input type="password" name="password-new" placeholder="NEW Password" class="input-element" required>
                <button type="submit" class="btn-element">Change Password</button>
                <h3 class="message"><span id="register-link2">Register</span> or <span id="login-link2">Log In</span></h3>
            </form>
        </div>

        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <?php

    // start xampp
    // sudo service apache2 stop
    // sudo /opt/lampp/lampp start

    /*
    * DONE:
    * --> LOGIN / REGISTER /CHANGE PASSWORD
    * --> CREATE TRANSITIONS BETWEEN THE FORMS IN index.php
    * --> SHOW QUERY FROM EXCERCISE 1.4 IF YOU CAN LOGIN
    *
    * PENDENTS:
    * --> CHECK HOW TO CREATE DINAMIC HTML WITH PHP(OR HOW TO COMMUNICATE PHP WITH JS)
    * --> SEE HOW TO PASS VARIABLES FROM PHP FILE WITH ONLY CODE TO PHP WITH HTML ON IT
    * --> MAKE BACKUP OF POSTGRES IN REAL TIME
    *
    */

    function sendData(){

    }

    ?>
</html>