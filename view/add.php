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
require_once "../src/addFormHandler.php";

if(isset($_POST['search']) && $_POST['search'] != ""){
    printMoneyForm();
    userList($_POST['search'], $db);
}else {
    if (isset($_POST['0'])) {
        match ($_POST['0']) {
            "sport" => printSportForm(),
            "game" => printGameForm($db),
            "money" => printMoneyForm(),
            "team" => printteamForm($db),
            "winner" => printWinnerForm($db),
            default => header("Location: adminpanel.php"),
        };
    } else {
        header("Location: adminpanel.php");
    }
}
?>
</body>
</html>