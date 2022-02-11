<?php

function check_login($connection)
{
    if (isset($_COOKIE['ADMIN_COOKIE'])) {

        $cookieData = json_decode($_COOKIE['ADMIN_COOKIE']);

        $_SESSION['USER_DATA'] = [
            'ADMIN_NAME' => $cookieData->ADMIN_NAME,
            'EMAIL' => $cookieData->EMAIL,
            'STATUS' => $cookieData->STATUS,
        ];
    }

    if (isset($_SESSION['USER_DATA'])) {

        $User_email_id = $_SESSION['USER_DATA']['EMAIL'];

        $sql = "select * from userAdmin where email = '$User_email_id'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $User = mysqli_fetch_assoc($result);
            return $User;
        } else {
            header("Location:../admin-login.php");
            die;
        }
    } else {
        header("Location:../admin-login.php");
        die;
    }
}


function get_token($size)
{
    $token = openssl_random_pseudo_bytes($size);
    $token = bin2hex($token);
    return $token;
}
