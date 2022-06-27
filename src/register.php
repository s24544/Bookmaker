<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\functions.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\NotAuthenticatedAccount.php';
/** @var PDO $db */
unset($_SESSION['error']);

/* 1. Validate data
 * 2. Hash password
 * 3. Insert account to accounts
 * 4. Insert into register activation code etc.
 * 5. Mail code
 * 6. echo "mail sent with activation code sent"
 */




if(!(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['passwordconfirm']) && isset($_POST['email'])))
{
    $_SESSION['error'] = "Enter all the details!";
    header("Location: signup.php");
}
$user = new NotAuthenticatedAccount();
$user->setLogin($_POST['login']);
$user->setPassword($_POST['password']);
$user->setEmail($_POST['email']);

if($user->validatePassword() != 1)
    $_SESSION['error'] = "Invalid password! <br>At least 8 characters: upper and lowercase character, number and special character";

if($user->getPassword() != $_POST['passwordconfirm'])
    $_SESSION['error'] = "Passwords are not the same!";

if($user->validateEmail() == false || $user->getEmail() != $_POST['email'])
    $_SESSION['error'] = "Invalid email";

if($user->validateLogin() == false)
    $_SESSION['error'] = "Invalid login! Login should containt 4-64 characters";

if(isset($_SESSION['error']))
{
    unset($user);
    header("Location: ../view/signup.php");
    die();
}


$exist = $user->checkIfUserExists($db);
if($exist["login"])
    $_SESSION['error'] = "User with this login already exists!<br>";
if($exist["email"])
    $_SESSION['error'] = $_SESSION['error']."User with this email already exists!";
if(isset($_SESSION['error']))
{
    header("Location: ../view/signup.php");
    die();
}

try{
    $password = password_hash($user->getPassword(), PASSWORD_ARGON2ID);
    $query = "INSERT INTO `bk`.`accounts` (`login`, `password`, `email`) VALUES (:login, :password, :email);";
    $insertQuery = $db->prepare($query);
    $insertQuery->bindValue(':login', $user->getLogin(), PDO::PARAM_STR);
    $insertQuery->bindValue(':password', $password, PDO::PARAM_STR);
    $insertQuery->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
    $insertQuery->execute();
}
catch (PDOException $error)
{
    echo $error->getMessage();
    die();
}

$id=getAccountIdFromLogin($user->getLogin(), $db);
if(boolval($id) == false)
    die("error, please contact Email:admin@localhost");

$date = date("Y-m-d H:i:s");
$expireDate = date('Y-m-d H:i:s', strtotime("+6 hours"));
$activationCode = hash('sha256', $user->getLogin().rand(0, 10000).$user->getEmail());//pewnie mozna lepiej, ale trudno
try{
    $query = "INSERT INTO `bk`.`account_register` (`token`, `create_date`, `expire_date`) VALUES (:code, :date, :expire);";
    $registerQuery = $db->prepare($query);
    $registerQuery->bindValue(':code', $activationCode, PDO::PARAM_STR);
    $registerQuery->bindValue(':date', $date, PDO::PARAM_STR);
    $registerQuery->bindValue(':expire', $expireDate, PDO::PARAM_STR);
    $registerQuery->execute();
    mail($user->getEmail(), "Activation code", "localhost/bookmaker/activate.php?email=".$user->getEmail()."&activation_code=$activationCode");
}
catch (PDOException $error)
{
    echo $error->getMessage();
    die();
}

//update register_id in accounts
 try{
     $query = "SELECT Register_id FROM bk.account_register WHERE token=:code AND create_date=:date AND expire_date=:expire";
     $selectQuery = $db->prepare($query);
     $selectQuery->bindValue(':code', $activationCode, PDO::PARAM_STR);
     $selectQuery->bindValue(':date', $date, PDO::PARAM_STR);
     $selectQuery->bindValue(':expire', $expireDate, PDO::PARAM_STR);
     $selectQuery->execute();
     $regId = $selectQuery->fetchColumn();
 }
 catch (PDOException $error)
{
    echo $error->getMessage();
    die();
}

try {
    $query = "UPDATE bk.accounts SET Register_Register_id=:reg WHERE login=:login AND email=:email";
    $updateQuery = $db->prepare($query);
    $updateQuery->bindValue(':reg', (int)$regId);
    $updateQuery->bindValue(':login', $user->getLogin(), PDO::PARAM_STR);
    $updateQuery->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
    if($updateQuery->execute())
        echo "OK<br>";

}catch (PDOException $error){
    echo $error->getMessage();
    die();
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account registered</title>
</head>
<body>
<?php
echo "Verification code with 6 hour expiration time sent to your email account. Please activate your account by clicking link in email!<br>";
$link = "http://localhost/wprgcwiczenia/Bookmaker/src/activate.php?email=".$user->getEmail()."&activation_code=".$activationCode;
echo '<a href='.$link.'>link</a>';
?>
</body>
</html>
