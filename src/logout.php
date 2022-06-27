<?php
session_start();
$tmp = isset($_POST['logged']);
session_destroy();
session_start();
$_SESSION['btnLogout'] = $tmp;
header('Location: index.php');