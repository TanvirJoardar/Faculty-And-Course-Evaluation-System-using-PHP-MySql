<?php
session_start();

if (isset($_COOKIE['ADMIN_COOKIE'])) {

    setcookie("ADMIN_COOKIE", "", time() - (3600 * 30), "/");
}

if (isset($_SESSION['USER_DATA'])) {

    unset($_SESSION['USER_DATA']);
}

session_destroy();

header("Location: index.php");
die;
