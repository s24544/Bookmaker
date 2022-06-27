<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\functions.php';
/** @var PDO $db */
unset($_SESSION['error']);


//regex for 8 characters
//1 uppercase, 1 lowercase letter
//1 number and 1 special characterd


$regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$/";
$login = $_POST['login'];
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

if(!(isset($_POST['go-in'])))
    errorRedirector('Wrong');


if(!(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['passwordconfirm']) && isset($_POST['email'])))
    errorRedirector("Enter all the details!");

if(preg_match($regex, $_POST['password']) == 0)
    errorRedirector("Invalid password! <br>At least 8 characters: upper and lowercase character, number and special character");

if($_POST['password'] != $_POST['passwordconfirm'])
    errorRedirector("Passwords are not the same!");

if($email != $_POST['email'] || strlen($email) > 320)
    errorRedirector("Invalid email!");

if(strlen($login) > 64 || strlen($login) < 4)
    errorRedirector("Invalid login! Login should containt 4-64 characters");

do {//password hashed with brcrypt should always be 60 characters long
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
}
while (strlen($password) != 60);


//test if database got already this login or mail
$exist = checkIfAlreadyExists($login, $email, $db);
if($exist[0] == true)
    $_SESSION['error'] = 'Account with this login already exists!<br>';
if($exist[1] == true)
    $_SESSION['error'] = $_SESSION['error']."Account with this email already exists!";
if(isset($_SESSION['error']))
    header('Location: register.php');



try{

    $query = "INSERT INTO `bookmaker`.`accounts` (`account_login`, `account_password`, `account_email`) VALUES (:login, :password, :email);";
    $insertQuery = $db->prepare($query);
    $insertQuery->bindValue(':login', $login, PDO::PARAM_STR);
    $insertQuery->bindValue(':password', $password, PDO::PARAM_STR);
    $insertQuery->bindValue(':email', $email, PDO::PARAM_STR);
    $insertQuery->execute();
}
catch (PDOException $error)
{
    echo $error;
    exit(PHP_EOL.'Insert to accounts error');
}

$id=getAccountIdFromLogin($login, $db);
if(getAccountIdFromLogin($login, $db) == false)
    $_SESSION['error'] = "SELECT ID ERROR";


if(isset($_SESSION['error']))
    header('Location: register.php');

try{

    $date = date("Y-m-d H:i:s");
    $expireDate = date('Y-m-d H:i:s', strtotime("+6 hours"));
    $activationCode = hash('sha256', rand(0, 10000) );
    $query = "INSERT INTO `bookmaker`.`register` (`account_id`, `register_date`, `activation_code`, `created_at`, `expiry_at`, `activated`) VALUES (:id, :registerdate, :code, :date, :expire, '0');";
    $registerQuery = $db->prepare($query);
    $registerQuery->bindValue(':id', $id, PDO::PARAM_INT);
    $registerQuery->bindValue(':registerdate', $date, PDO::PARAM_STR);
    $registerQuery->bindValue(':code', $activationCode, PDO::PARAM_STR);
    $registerQuery->bindValue(':date', $date, PDO::PARAM_STR);
    $registerQuery->bindValue(':expire', $expireDate, PDO::PARAM_STR);
    $registerQuery->execute();
    //TODO: Funkcja wysyłająca maile w tej linii: /activate.php?email=email&activation_code=abcd
}
catch (PDOException $error)
{
    echo $error;
    exit(PHP_EOL.'Insert error');
}
echo "Verification code with 6 hour expiration time sent to your email account. Please activate your account by clicking link in email!<br>";
$link = "http://localhost/wprgcwiczenia/Bookmaker/src/activate.php?email=$email&activation_code=".getActivationCode($email, $db);
echo '<a href='.$link.'>link</a>';//TODO:dokonczyc jako mailer
