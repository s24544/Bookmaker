<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\User.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\functions.php';
///** @var PDO $db */
//$login = "essa";
//$email = "jankreft10@gmail.com";
//
////$id=getAccountIdFromLogin($login, $db);
////activateUser($id, $db);
//$login = "jankreft";
////$password = "@bCd1234";
////$code = 'e32df00f65acc1db0a8264012e7074dbc58bd6f47b8c52004e0ab59244740cd5';
////if(getActivationCode($email, $db))
////    echo getActivationCode($email, $db);
////else
////    echo "brak";
//$linka = "http://localhost/wprgcwiczenia/Bookmaker/src/activate.php?email=$email&activation_code=".getActivationCode($email, $db);
//?>
<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <title>Document</title>-->
<!--</head>-->
<!--<body>-->
<?php
//echo '<a href='.$linka.'>link</a>';
//
//?>
<!--</body>-->
<!--</html>-->

<?php
//function CallAPI($method, $url, $data = false)
//{
//    $curl = curl_init();
//
//    switch ($method)
//    {
//        case "POST":
//            curl_setopt($curl, CURLOPT_POST, 1);
//
//            if ($data)
//                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//            break;
//        case "PUT":
//            curl_setopt($curl, CURLOPT_PUT, 1);
//            break;
//        default:
//            if ($data)
//                $url = sprintf("%s?%s", $url, http_build_query($data));
//    }
//
//    // Optional Authentication:
//    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//    curl_setopt($curl, CURLOPT_USERPWD, "username:password");
//
//    curl_setopt($curl, CURLOPT_URL, $url);
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//
//    $result = curl_exec($curl);
//
//    curl_close($curl);
//
//    return $result;
//}
//$method = "GET";
//$url = "https://altapi.kpostek.dev/v1/timetable/date/2022-05-05?groups=Gls l.1 - 103l";
//$data ='';
////echo strlen(CallAPI($method, $url, $data))."<br>";
//$essa = CallApi($method, $url, $data);
//$essa2 = json_decode($essa);
//echo $essa2;
//echo "<br>";
//var_dump($essa2);
/** @var PDO $db */
try {
    $query = "SHOW VARIABLES LIKE 'version';";
    $loginQuery = $db->prepare($query);
    $loginQuery->execute();
    $queryResult = $loginQuery->fetch();
    var_dump($queryResult);
} catch (PDOException $error) {
    echo $error;
    exit(PHP_EOL . 'Log-in error!');
}

echo phpinfo();

?>