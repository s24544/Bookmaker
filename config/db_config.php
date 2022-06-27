<?php
session_start();
$dbHost = '127.0.0.1';
$dbName = "Bookmaker";
$dbUser = "root";
$dbPassword = "";
$dbPort = "1025";

return ['host'=>$dbHost,
    'user'=>$dbUser,
    'password'=>$dbPassword,
    'database'=>$dbName,
    'port'=>$dbPort
    ];