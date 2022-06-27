<?php
session_start();
if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
    header('Location: main.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookmaker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="auth.php" method="post">
    <label for="login">
        Login:<br>
        <input type="text" name="login" id="login" required><br>
    </label>
    <label for="password">
        Password:<br>
        <input type="password" name="password" id="password" required><br>
    </label>
    <button type="submit" name="submit" value="submit">submit</button>
</form>
<?php
if(isset($_SESSION['error']) && $_SESSION['error'] == true)
    echo $_SESSION['error'];

if(isset($_SESSION['btnLogout']) && $_SESSION['btnLogout'] == true)
    echo "Logged out!";
?>
</body>
</html>