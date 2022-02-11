<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
include('admin/config/database.php');
include('includes/function.php');
?>


<?php

// Variable
$User = $Student_id = $Password = "";

// Error
$Student_idErr = $PasswordErr = "";

// Token
if (!isset($_POST['token'])) {
    $_SESSION['token'] = get_token(16);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['token']) {

    // Student ID Verify
    if (empty($_POST["stdid"])) {
        $Student_idErr = "Student ID is required";
    } else {
        $Student_id = test_input($_POST["stdid"]);

        $sql = "select student_id,password,name,status,email from user where student_id = '$Student_id'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $User = mysqli_fetch_assoc($result);

            if ($User['student_id'] != $Student_id) {
                $Student_idErr = "Student ID is not Matched";
            }
        } else {
            $Student_idErr = "Student ID is not Matched";
        }
    }



    // Password Verify
    if (empty($_POST["password"])) {
        $PasswordErr = "password is required";
    } else {
        $Password = test_input($_POST["password"]);

        if (isset($User['student_id'])) {

            if ($User['password'] != $Password) {
                $PasswordErr = "Password is not Matched";
            }
        } else {
            $PasswordErr = "Password is not Matched";
        }
    }


    // insert to database

    if ($Student_idErr == "" && $PasswordErr == "") {


        if (isset($_POST['submit'])) {

            $_SESSION['USER_DATA'] = [
                'STUDENT_ID' => $User['student_id'],
                'STUDENT_NAME' => $User['name'],
                'EMAIL' => $User['email'],
                'STATUS' => $User['status'],
            ];
            $_SESSION['message'] = 'Login Successfull';
            // $_SESSION['role'] = 0;     // Have to manage user role

            if (isset($_COOKIE['ADMIN_COOKIE'])) {

                setcookie("ADMIN_COOKIE", "", time() - (3600 * 30), "/");
            }

            if (isset($_POST['remember_me'])) {

                $cookie_name = "USER_COOKIE";
                $cookie_value = [

                    'STUDENT_ID' => $User['student_id'],
                    'STUDENT_NAME' => $User['name'],
                    'EMAIL' => $User['email'],
                    'STATUS' => $User['status'],
                ];
                setcookie($cookie_name, json_encode($cookie_value), time() + (3600 * 30), "/"); // 3600 = 1 hour

            }

            mysqli_close($connection);

            header("Location: index.php");
            die;
        }
    }
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<div class="py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <?php
                include('message.php');   // printing error message

                ?>
                <form action="login.php" method="post">
                    <div class="card">
                        <div class="card-header">
                            <h4>Student Login</h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                            <div class="from-group mb-3">
                                <label>Student ID</label>
                                <input type="text" name="stdid" value="<?= $Student_id ?>" placeholder="Enter Student ID" class="form-control">
                                <?php if ($Student_idErr != "") {
                                    echo '<span style="color: red">' . '* ' . $Student_idErr . '</span><br>';
                                } ?>
                            </div>
                            <div class="from-group mb-3">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Enter Password" class="form-control">
                                <?php if ($PasswordErr != "") {
                                    echo '<span style="color: red">' . '* ' . $PasswordErr . '</span><br>';
                                } ?>
                            </div>
                            <div class="from-group mb-3">
                                <input type="checkbox" name="remember_me" value="yes">
                                <label>Remember Me</label><br><br>
                            </div>
                            <div class="from-group mb-3">
                                <input type="submit" name="submit" class="btn btn-primary" value="Login Now">

                            </div>


                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>


<?php
include('includes/footer.php');

?>