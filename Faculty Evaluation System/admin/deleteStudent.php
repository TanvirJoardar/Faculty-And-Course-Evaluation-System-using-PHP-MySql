<?php

include('config/database.php');


if (isset($_POST['delete'])) {

    $user_id = $_POST['delete'];

    $sql = "delete from user where id='$user_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['message'] = 'Deleted Successfully';
    } else {
        $_SESSION['message'] = 'Deletion is not Successfully';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewStudent.php");
    die;
}
