<?php

$config = require_once __DIR__.'./db_config.php';

try{
    global $db;
    $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};port={$config['port']};charset=utf8", $config['user'], $config['password'], [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

} catch (PDOException $error){
    echo $error;
    exit('Database error');
}