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
    <title>My bets</title>
</head>
<body>
<?php
require_once "../src/header.php";
require_once "../src/showBets.php";
?>
<br>
<?php
    foreach (getUserBets($user->getId(), $db) as $bet) {
        try {
            echo "Bet place date: " . $bet["datetime"] . "<br>";
            echo "Money placed: " . $bet["bet_money"] . "<br>";
            echo "Odd: " . $bet["odd"] . "<br>";
            if (isset($bet["Teams_id"]))
                echo "Team: " . getTeamName($bet["Teams_id"], $db)["name"] . "<br>";
            if ($bet["game_status"] == 1)
                echo "Money won: " . round($bet["bet_money"] * $bet["odd"], 2) . "<br>";
            else
                echo "Possible win: " . round($bet["bet_money"] * $bet["odd"], 2) . "<br>";
            echo "Game result: " . $bet["game_result"] . "<br>";
            echo "Bet status: ";
            echo match ($bet["game_status"]) {
                1 => "Won",
                0 => "Lost",
                default => "Waiting for results",
            };
            echo "<br><br>";
        }catch (TypeError $e)
        {
            echo "No bets";
        }
    }
?>



</body>
</html>
