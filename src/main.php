<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\User.php';
if($_SESSION['logged'] == false)
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
    <title>Main</title>
</head>
<body>
<?php
echo "Witaj, ".$user->getLogin()."<br>";
?>
<form action="logout.php" method="post">
    <label for="logout">
        <input type="submit" name="btnLogout" id="logout" alt="essa" value="Log out">
    </label>
</form>
</body>
</html>
