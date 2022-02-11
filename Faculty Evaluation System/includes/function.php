<?php

function check_login($connection)
{
    if (isset($_COOKIE['USER_COOKIE'])) {

        $cookieData = json_decode($_COOKIE['USER_COOKIE']);

        $_SESSION['USER_DATA'] = [
            'STUDENT_ID' => $cookieData->STUDENT_ID,
            'STUDENT_NAME' => $cookieData->STUDENT_NAME,
            'EMAIL' => $cookieData->EMAIL,
            'STATUS' => $cookieData->STATUS,
        ];
    }

    if (isset($_SESSION['USER_DATA'])) {

        $User_email_id = $_SESSION['USER_DATA']['EMAIL'];

        $sql = "select * from user where email = '$User_email_id'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $User = mysqli_fetch_assoc($result);
            return $User;
        } else {
            header("Location:login.php");
            die;
        }
    } else {
        header("Location:login.php");
        die;
    }
}


function get_token($size)
{
    $token = openssl_random_pseudo_bytes($size);
    $token = bin2hex($token);
    return $token;
}
