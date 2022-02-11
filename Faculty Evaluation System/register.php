<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
include('admin/config/database.php');

?>

<!-- Form validation -->

<?php


// Variable
$Name = $Student_id = $Email = $Password = $Conf_password = "";

// Error
$NameErr = $Student_idErr = $EmailErr = $PasswordErr = $Conf_passwordErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Name validation
    if (empty($_POST['name'])) {
        $NameErr = "Name is required";
    } else {
        $Name = test_input($_POST["name"]);
        // $strremove = preg_replace("/\s+/", "", $Name);
        $namelen = strlen($Name);
        if ($namelen < 4 || $namelen > 20) {
            $NameErr = "Name must be between 4 and 20 characters";
        }
        // check if name only contains letters and whitespace
        elseif (!preg_match("/^([a-zA-Z-']+\s[a-zA-Z-']+(\s[a-zA-Z-']+)?)$/", $Name)) {
            if (preg_match("/^([a-zA-Z-']+)$/", $Name)) {
                $NameErr = "Last Name required";
            } else {
                $NameErr = "Only letters and white space allowed";
            }
        }
    }


    // Student ID validation
    if (empty($_POST["stdid"])) {
        $Student_idErr = "Student ID is required";
    } else {
        $Student_id = test_input($_POST["stdid"]);

        // $db_sid = "";
        $sql = "select student_id from user where student_id = '$Student_id'";
        $result = mysqli_query($connection, $sql);


        if (!preg_match("/^[0-9]{4}-[0-9]{1}-[0-9]{2}-[0-9]{3}$/", $Student_id)) {
            $Student_idErr = "Invalid Student ID";
        }
        if ($result && mysqli_num_rows($result) > 0) {


            $db_sid = mysqli_fetch_assoc($result);
            if ($db_sid['student_id'] == $Student_id) {
                $Student_idErr = "This Student ID is Already Exists";
            }
        }
    }

    // Email validation
    if (empty($_POST["email"])) {
        $EmailErr = "Email is required";
    } else {
        $Email = test_input($_POST["email"]);

        $sql = "select email from user where email = '$Email'";
        $result = mysqli_query($connection, $sql);

        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $EmailErr = "Invalid email format";
        }
        if ($result && mysqli_num_rows($result) > 0) {


            $db_eid = mysqli_fetch_assoc($result);
            if ($db_eid['email'] == $Email) {
                $EmailErr = "This Email ID is Already Exists";
            }
        }
    }

    // Password validation
    if (empty($_POST["password"])) {
        $PasswordErr = "password is required";
    } else {
        $Password = test_input($_POST["password"]);
        $passlen = strlen($Password);
        if ($passlen < 8 || $passlen > 20) {
            $PasswordErr = "Password must be between 8 and 20 characters";
        } elseif (!preg_match('/[A-Z]/', $Password)) {
            $PasswordErr = "Password must contain at least 1 uppercase leter";
        } elseif (!preg_match('/[a-z]/', $Password)) {
            $PasswordErr = "Password must contain at least 1 lowercase leter";
        } elseif (!preg_match('/[0-9]/', $Password)) {
            $PasswordErr = "Password must contain at least 1 digit";
        } elseif (preg_match('/[!@#$%^&*()]/', $Password)) {
            $PasswordErr = "Password mustn't contain any special charecter";
        }
    }

    if (empty($_POST["conf_password"])) {
        $Conf_passwordErr = "Confirm your Password";
    } else {
        $Conf_password = test_input($_POST["conf_password"]);
        if ($Password != $Conf_password) {
            $Conf_passwordErr = "Confirm Password Incorrect";
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


// insert to database

if ($NameErr == "" && $Student_idErr == "" && $EmailErr == "" && $PasswordErr == "" && $Conf_passwordErr == "") {


    if (isset($_POST['submit'])) {


        // Performing insert query execution
        $sql = "INSERT INTO user(id, name, student_id, email, password) VALUES ('','$Name','$Student_id','$Email','$Password')";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Registration Successfull';
        } else {
            $_SESSION['message'] = 'Registration is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: login.php");
        die;
    }
}

?>



<div class="py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <?php
                include('message.php');   // printing error message

                ?>
                <form action="register.php" method="post">
                    <div class="card">
                        <div class="card-header">
                            <h4>Student Register</h4>
                        </div>
                        <div class="card-body">
                            <div class="from-group mb-3">
                                <label>Full Name</label>
                                <input type="text" name="name" value="<?= $Name ?>" placeholder="Enter Full Name" class="form-control">
                                <?php if ($NameErr != "") {
                                    echo '<span style="color: red">' . '* ' . $NameErr . '</span><br>';
                                } ?>
                            </div>
                            <div class="from-group mb-3">
                                <label>Student ID</label>
                                <input type="text" name="stdid" value="<?= $Student_id ?>" placeholder="Enter Student ID" class="form-control">
                                <?php if ($Student_idErr != "") {
                                    echo '<span style="color: red">' . '* ' . $Student_idErr . '</span><br>';
                                } ?>
                            </div>
                            <div class="from-group mb-3">
                                <label>Email</label>
                                <input type="email" name="email" value="<?= $Email ?>" placeholder="Enter Email ID" class="form-control">
                                <?php if ($EmailErr != "") {
                                    echo '<span style="color: red">' . '* ' . $EmailErr . '</span><br>';
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
                                <label>Confirm Password</label>
                                <input type="password" name="conf_password" placeholder="Confirm Password" class="form-control">
                                <?php if ($Conf_passwordErr != "") {
                                    echo '<span style="color: red">' . '* ' . $Conf_passwordErr . '</span><br>';
                                } ?>
                            </div>
                            <div class="from-group mb-3">
                                <input type="submit" name="submit" class="btn btn-primary" value="Register Now">
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