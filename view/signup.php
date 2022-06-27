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
    <script src="../src/script.js"></script>
</head>
<body>
<ul>
    <li id="logo"><a href="index.php">Bookmaker</a></li>
    <li><a href="../src/bets.php">BETS</a></li>
    <li class="right"><a href="signup.php" class="this">Sign up</a></li>
    <li class="right"><a href="login.php">Sign in</a></li>
</ul>
<form class="form" action="../src/register.php" method="POST">
    <h1>Sign up</h1>
    <label for="login" id="login">
        Login:<br>
        <input type="text" name="login" autocomplete="off" required onkeyup="showError(this.value, 'loginHint')"><br>
    </label>
    <label for="email" id="email">
        Email:<br>
        <input type="email" name="email" maxlength="320" autocomplete="off" required onkeyup="showError(this.value, 'emailHint')"><br>
    </label>
    <label for="password" id="password">
        Password:<br>
        <input type="password" minlength="8" id="firstpassword" onkeyup="passwordHint()" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$" title="At least: 1 uppercase character and lowercase character, 1 number and 1 symbol !@#$%^&*_=+-" name="password" autocomplete="off" required><br>
    </label>
    <span id="hint"></span>
    <label for="password-confirm" id="password-confirm">
        Confirm password:<br>
        <input type="password" minlength="8" onkeyup="passwordCompare()" id="secondpassword" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$" title="Confirm password" name="passwordconfirm" autocomplete="off" required><br>
    </label>
    <span id="compare"></span>
    <label for="submit" id="submit"><br>
        <button type="submit" name="submit" value="Register">REGISTER</button>
    </label><br><br>
    <span class="error" id="loginHint"></span><br>
    <span class="error" id="emailHint"></span>
    <?php
    if(isset($_SESSION['error']))
        echo "<br>".$_SESSION['error'];
    unset($_SESSION['error']);
    ?>
</form>
</body>
</html>