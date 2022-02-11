<?php
// session_start();

include('config/database.php');

function page()
{

    global $connection;
    if (isset($_SERVER['HTTPS'])) {

        $actual_link = "https://" . $_SERVER['HTTP_HOST'] . "" . $_SERVER['REQUEST_URI'];
    } else {
        $actual_link = "http://" . $_SERVER['HTTP_HOST'] . "" . $_SERVER['REQUEST_URI'];
    }

    $page_url = trim($actual_link);
    $page_id = md5(trim($page_url));
    $email = $_SESSION['USER_DATA']['EMAIL'];

    $query = "SELECT * FROM pages WHERE pages.page_id = '$page_id' and email = '$email'";
    $result = mysqli_query($connection, $query);

    $sess = $email . $page_id;

    if (!isset($_SESSION[$sess])) {

        $_SESSION[$sess] = 'yes';

        if (mysqli_num_rows($result) == 0) {
            $insert_sql = "INSERT INTO pages (email,page,page_id,number) VALUES ('$email','$page_url','$page_id',1)";
            if (mysqli_query($connection, $insert_sql)) {
                return true;
            } else {
                return false;
            }
        } else {
            $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $number = intval(trim($data['number'])) + 1;
            $update_sql = "UPDATE pages SET number='$number' WHERE pages.page_id = '$page_id' and email = '$email'";
            if (mysqli_query($connection, $update_sql)) {
                return true;
            } else {
                return false;
            }
        }
    }
}

page();
