<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\AuthenticatedAccount.php';
if(!isset($_SESSION['logged']) || $_SESSION['logged'] != true)
    header("Location: index.php");
$user = unserialize($_SESSION['user'], array(true));
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bets</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-danger text-center text-uppercase">
    <a class="navbar-brand text-white" href="../view/app.php">book</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white active" href="../view/app.php">bets<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">your bets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Pricing</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown link
                </a>
                <div class="dropdown-menu bg-danger" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item text-white" href="#">Action</a>
                    <a class="dropdown-item text-white" href="#">Another action</a>
                    <a class="dropdown-item text-white" href="#">Something else here</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<br>
essa





</body>
</html>
