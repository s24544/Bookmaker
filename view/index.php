<?php
require_once '../src/showBets.php';
require_once '../config/database.php';
if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
    header("Location: app.php");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bookmaker</title>
</head>
<body>
<ul>
    <li id="logo"><a href="index.php" class="this">Bookmaker</a></li>
    <li><a href="../view/app.php">BETS</a></li>
    <li class="right"><a href="signup.php">Sign up</a></li>
    <li class="right"><a href="login.php">Sign in</a></li>
</ul>
Bookmaker site


</body>
</html>