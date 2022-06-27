<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\AuthenticatedAccount.php';
if($_SESSION['logged'] != true || !isset($_SESSION['logged']))
    header("Location: login.php");
$user = unserialize($_SESSION['user'], array(true));
$user->setData($db);
$userFromList = $_POST["user"];
if (!isset($user->getProfile()['admin']) || $user->getProfile()['admin'] != true)
    header("Location: index.php");
if(!isset($_POST['user']) || $_POST['user'] == "" || count($_POST['user']) != 4)
    header("Location: ../view/adminpanel.php");
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
echo '<form action="../src/addmoney.php" method="post">';
echo '<input type="hidden" name="user[id]" value="'.$userFromList["id"].'">';
echo '<input type="hidden" name="user[login]" value="'.$userFromList["login"].'">';
echo '<input type="hidden" name="user[email]" value="'.$userFromList["email"].'">';
echo '<input type="hidden" name="user[money]" value="'.$userFromList["money"].'">';
echo "ID: ".$userFromList["id"]."<br>";
echo "Login: ".$userFromList["login"]."<br>";
echo "Email: ".$userFromList["email"]."<br>";
echo "Money: ".$userFromList["money"]."<br>";
echo '<input type="number" min="0.01" step="0.01" name="money"><br>';
echo '<button>ADD</button>';
echo "</form>";
?>




    </body>
</html>
