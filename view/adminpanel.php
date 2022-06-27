<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\AuthenticatedAccount.php';
if($_SESSION['logged'] != true || !isset($_SESSION['logged']))
    header("Location: login.php");
$user = unserialize($_SESSION['user'], array(true));
$user->setData($db);
if (!isset($user->getProfile()['admin']) || $user->getProfile()['admin'] != true)
    header("Location: index.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin panel</title>
</head>
<body>
<?php
require_once "../src/header.php";
if(isset($_SESSION["status"])) {
    echo $_SESSION["status"]."<br>";
    unset($_SESSION["status"]);
}
?>
<form action="add.php" method="POST">
    ADD<br>
    <button value="money" name="0">Money</button><br><br>
    <button value="game" name="0">Game</button><br><br>
    <button value="team" name="0">Team</button><br><br>
    <button value="sport" name="0">Sport</button><br><br>
    <button value="winner" name="0">Winner</button>
</form>


</body>
</html>