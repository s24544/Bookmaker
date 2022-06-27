<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\AuthenticatedAccount.php';
require_once '../src/addFormHandler.php';
if($_SESSION['logged'] != true || !isset($_SESSION['logged']))
    header("Location: login.php");
$user = unserialize($_SESSION['user'], array(true));
$user->setData($db);

if (!isset($user->getProfile()['admin']) || $user->getProfile()['admin'] != true)
    header("Location: index.php");

if(!isset($_POST['game_datetime']) || !isset($_POST['start_bet']) || !isset($_POST["end_bet"]) || !isset($_POST["number"]))
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
<?php require_once "../src/header.php"; ?>
<br>

<?php
echo "<br>Game datetime: ".str_replace('T',' ', $_POST['game_datetime']);
echo "<br>Game allow bet from: ".str_replace('T',' ', $_POST['start_bet']);
echo "<br>Game stop bet at: ".str_replace('T',' ', $_POST['end_bet'])."<br><br>";
echo '<form action="../src/addgame.php" method="post">';
echo '<input type="hidden" name="game_datetime" value="'.$_POST["game_datetime"].'">';
echo '<input type="hidden" name="start_bet" value="'.$_POST["start_bet"].'">';
echo '<input type="hidden" name="end_bet" value="'.$_POST["end_bet"].'">';
$selectTeam = '<select name="team[]" id="">';
foreach (getTeams($_POST["sport"], $db) as $team){
    $selectTeam .= '<option value="'.$team["id"].'">'.$team["name"]."</option>";
}
$selectTeam .= "</select>";


for($i=0;$i<$_POST["number"];$i++){
    echo "Team: ".$selectTeam."<br>";
    echo 'Odd: <input type="number" step=0.01 name="odd[]" min="1"><br>';
    echo "<br>";
}
echo '</select>';
?>
<button type="submit">ADD</button>
</form>
    </body>
</html>
