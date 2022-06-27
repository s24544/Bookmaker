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
?>
<form action="../src/addsport.php" method="POST">
    ADD SPORT<br>
    Sport name: <input type="text" name="name"><br>
    Logo path: <input type="text" name="logo_path"><br>
    <button>Submit</button>
</form>
</body>
</html>