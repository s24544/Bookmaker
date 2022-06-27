<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\AuthenticatedAccount.php';

if(!isset($_SESSION['logged']) || $_SESSION['logged'] != true)
    header("Location: index.php");
$user = unserialize($_SESSION['user'], array(true));
$user->setData($db);
$admin = $user->isAdmin($db);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My profile</title>
    <script src="../src/script.js"></script>
</head>
<body>
<?php
require_once "../src/header.php";
echo "<br>";
if(isset($_SESSION["update"])) {
    echo $_SESSION["update"];
    unset($_SESSION["update"]);
}
?>
<form action="../src/updateProfile.php" method="post">
    Register date: <?php echo $user->getProfile()["register_date"];?><br>
    Money: <?php echo $user->getMoney($db);?><br><br>
    Name: <input type="text" name="name" value="<?php echo $user->getProfile()['name']?>"><br>
    Surname: <input type="text" name="surname" value="<?php echo $user->getProfile()['surname']?>"><br>
    Country: <select name="country" id="">
    <?php
    try{
        $selectSql = "SELECT * FROM bk.country";
        $query = $db->prepare($selectSql);
        $query->execute();
        $result = $query->fetchAll();
    }catch (PDOException $error){
        echo $error->getMessage();
        die();
    }

    foreach ($result as $country){
        if($country['country'] == $user->getProfile()['country'])
            echo '<option selected="selected" value="'.$country["country_id"].'">'.$country['country']."</option>";
        else
            echo '<option value="'.$country["country_id"].'">'.$country['country']."</option>";
    }
    ?>
    </select><br>
    City: <input type="text" name="city" value="<?php echo $user->getProfile()['city']?>"><br>
    District: <input type="text" name="district" value="<?php echo $user->getProfile()['district']?>"><br>
    Postal code: <input type="text" name="postal_code" value="<?php echo $user->getProfile()['postal_code']?>"><br>
    Street: <input type="text" name="street" value="<?php echo $user->getProfile()['street']?>"><br>
    <button>Save</button>
</form>
<?php //TODO: Save do bazy danych ?>
</body>
</html>
