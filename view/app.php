<?php
require_once '..\src\AuthenticatedAccount.php';
if(!isset($_SESSION['logged']) || $_SESSION['logged'] != true)
    header("Location: index.php");
$user = unserialize($_SESSION['user'], array(true));
$user->setData($db);
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
<?php
require_once "../src/header.php";
require_once "../src/showBets.php";
if(isset($_SESSION["bet"])) {
    echo $_SESSION["bet"]."<br>";
    unset($_SESSION["bet"]);
}
printSportSelect($db);

$notTeamableSport = [6, 7, 8];
echo "<br>";
if(isset($_POST["id"]) && !in_array($_POST["id"], $notTeamableSport))
    printActiveTeamsBets(getActiveSportBets($_POST["id"], $db));
else{
    echo "All bets: <br>";
    printActiveTeamsBets(getActiveTeamsBets($db));
}

unset($_POST["id"]);
?>
</body>
</html>
