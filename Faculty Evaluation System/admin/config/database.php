<?php

$dbhost = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "Faculty_Evaluation";

if (!$connection = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname)) {
    header('Location: ../errors/dberr.php');
    die();
}
