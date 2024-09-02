<?php

$dsn = "mysql:host=localhost;dbname=firstdatabase";
$dbuser = "root";
$dbpassword = "";


try{
    $pdo =  new PDO($dsn, $dbuser, $dbpassword); #php data object or mysqli
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "connection failed" . $e->getMessage();
}


