<?php
session_start();

if (isset($_COOKIE['USER_COOKIE'])) {

    setcookie("USER_COOKIE", "", time() - (3600 * 30), "/");
}
if (isset($_SESSION['USER_DATA'])) {

    unset($_SESSION['USER_DATA']);
}

header("Location: index.php");
die;
