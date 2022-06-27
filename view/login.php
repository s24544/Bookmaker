<?php
session_start();
if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
    header('Location: app.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body>
<ul>
    <li id="logo"><a href="index.php">Bookmaker</a></li>
    <li><a href="../src/bets.php">BETS</a></li>
    <li class="right"><a href="signup.php">Sign up</a></li>
    <li class="right"><a href="login.php" class="this">Sign in</a></li>
</ul>
<form class="form" action="../src/auth.php" method="post">
    <h1>Sign in</h1>
    <label for="login">
        Login:<br>
        <input type="text" class="essa" autocomplete="off" name="login" id="login" required><br>
    </label>
    <label for="password">
        Password:<br>
        <input type="password" autocomplete="off" name="password" id="password" required><br>
    </label>
    <br>
    <button type="submit" name="submit" value="submit">Log in</button>
    <br>
</form>
<?php
if(isset($_SESSION['error']))
    echo "<br><div class='error'>".$_SESSION['error']."</div>";

session_unset();
?>
</body>
</html>
