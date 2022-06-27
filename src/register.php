<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
</head>
<body>
<form action="createuser.php" method="POST">
    <label for="login" id="login">
        Login:<br>
        <input type="text" name="login" required><br>
    </label>
    <label for="email" id="email">
        Email:<br>
        <input type="email" name="email" maxlength="320" required><br>
    </label>
    <label for="password" id="password">
        Password:<br>
        <input type="password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$" title="At least: 1 uppercase character and lowercase character, 1 number and 1 symbol !@#$%^&*_=+-" name="password" required><br>
    </label>
    <label for="password-confirm" id="password-confirm">
        Confirm password:<br>
        <input type="password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$" title="Confirm password" name="passwordconfirm" required><br>
    </label>
    <label for="submit" id="submit">
        <input type="submit" value="Register" name="go-in">
    </label>
    <?php
    if(isset($_SESSION['error']))
        echo "<br>".$_SESSION['error'];
    unset($_SESSION['error']);
    ?>
</form>
</body>
</html>