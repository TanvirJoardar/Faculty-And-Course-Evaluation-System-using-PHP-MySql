<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
?>

<!-- Form validation -->

<?php


// Variable
$Name = $Email = $Student_id = $Password = $user_id = "";

// Error
$NameErr = $Student_idErr = $EmailErr = $PasswordErr = "";

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
        $std_tab_id = test_input($_SESSION["std_id"]);

        // $db_sid = "";
        $sql = "select student_id from user where student_id = '$Student_id' and id != '$std_tab_id'";
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
        $std_tab_id = test_input($_SESSION["std_id"]);

        $sql = "select email from user where email = '$Email' and id != '$std_tab_id'";
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
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


// insert to database

if ($NameErr == "" && $EmailErr == "" && $PasswordErr == "" && $Student_idErr == "") {

    if (isset($_POST['submit'])) {

        // Performing insert query execution
        $user_id = $_GET['id'];
        $sql = "UPDATE user SET name = '$Name',student_id = '$Student_id', email = '$Email',password = '$Password' WHERE id='$user_id'";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Update Student info Successfully';
            unset($_SESSION['std_id']);
        } else {
            $_SESSION['message'] = 'Update Student info is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: viewStudent.php");
        ob_end_flush();                       // for header() error
        die;
    }
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Edit Students</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Registered Students</h4>

                </div>
                <div class="card-body">

                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $sql = "select * from user where id='$user_id'";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            foreach ($result as $row) {
                                $_SESSION['std_id'] = $row['id'];

                    ?>
                                <!--  need to change action-->
                                <form action="editStudent.php?id=<?= $user_id; ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="">Full Name</label>
                                            <input type="text" name="name" value="<?= $row['name']; ?>" class="form-control" id="">
                                            <?php if ($NameErr != "") {
                                                echo '<span style="color: red">' . '* ' . $NameErr . '</span><br>';
                                            } ?>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="">Student ID</label>
                                            <input type="text" name="stdid" value="<?= $row['student_id']; ?>" class="form-control" id="">
                                            <?php if ($Student_idErr != "") {
                                                echo '<span style="color: red">' . '* ' . $Student_idErr . '</span><br>';
                                            } ?>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="">Email</label>
                                            <input type="email" name="email" value="<?= $row['email']; ?>" class="form-control" id="">
                                            <?php if ($EmailErr != "") {
                                                echo '<span style="color: red">' . '* ' . $EmailErr . '</span><br>';
                                            } ?>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="">Password</label>
                                            <input type="password" name="password" class="form-control" id="">
                                            <?php if ($PasswordErr != "") {
                                                echo '<span style="color: red">' . '* ' . $PasswordErr . '</span><br>';
                                            } ?>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <input type="submit" name="submit" value="Update Student" class="btn btn-success" id="">
                                            <a class="btn btn-primary" href="viewStudent.php">Cancel</a>
                                        </div>
                                    </div>

                                </form>

                            <?php
                            }
                        } else {
                            ?>
                            <h4>No Record Found</h4>
                    <?php
                        }
                    }

                    ?>

                </div>
            </div>
        </div>

    </div>

</div>



<?php
include('includes/footer.php');
include('includes/scripts.php');
?>