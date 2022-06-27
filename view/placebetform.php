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
echo "<br>";
$userMoney = $user->getMoney($db);
if(isset($_POST["game_id"]))
    $game = getGameInfo($_POST["game_id"], $db);
?>
    <?php
    if(!isset($_POST["Gt_id"]))
        foreach ($game as $g){
        echo '<form action="placebetform.php" method="post">';
        echo '<input type="hidden" name="Gt_id" value="'.$g["Gt_id"].'">';
        if (isset($g["Teams_id"]))
            echo getTeamName($g["Teams_id"], $db)["name"]."<br>";
        echo "ODD: ".$g["odd"]."<br>";
        echo "GAME RESULT: ".$g["game_result"]."<br><button>BET</button><br><br>";
        echo '</form>';
        }
    else {
        if (!isset($_POST["money"])) {
            echo "Max bet: " . $userMoney . "<br><br>";
            $bet = getBetInfo($_POST["Gt_id"], $db);
            echo '<form action="placebetform.php" method="post">';
            echo getTeamName($bet[0]["Teams_id"], $db)["name"] . "<br>";
            echo "ODD: " . $bet[0]["odd"] . "<br>";
            echo '<input type="hidden" name="odd" value="' . $bet[0]["odd"] . '">';
            echo '<input type="hidden" name="Gt_id" value="' . $_POST["Gt_id"] . '">';
            echo '<input type="hidden" name="Teams_id" value="' . $bet[0]["Teams_id"] . '">';
            echo '<input type="hidden" name="game_result" value="' . $bet[0]["game_result"] . '">';
            echo '<input type="number" name="money" min="0" max="' . $userMoney . '" step="0.01"><br>';
            echo '<button>PLACE BET</button>';
        } else {
            echo '<form action="../src/placebet.php" method="post">';
            if ($_POST["money"] > $userMoney || $_POST["money"] <= 0) {
                echo "ERROR";
                die();
            }
            echo getTeamName($_POST["Teams_id"], $db)["name"] . "<br>";
            echo "Money bet: " . $_POST["money"]."<br>";
            echo "Game result: " . $_POST["game_result"]."<br>";
            echo "Possible win: " . round($_POST["money"] * $_POST["odd"], 2)."<br>";
            echo '<input type="hidden" name="Gt_id" value="'.$_POST["Gt_id"].'">';
            echo '<input type="hidden" name="money" value="'.$_POST["money"].'">';
            echo "<button>CONFIRM BET</button>";
        }
    }
    ?>

</body>
</html>
