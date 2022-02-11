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
$Name = $Email = $Password = $user_id = "";

// Error
$NameErr = $EmailErr = $PasswordErr = "";

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



    // Email validation
    if (empty($_POST["email"])) {
        $EmailErr = "Email is required";
    } else {
        $Email = test_input($_POST["email"]);

        $sql = "select email from userAdmin where email = '$Email'";
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

if ($NameErr == "" && $EmailErr == "" && $PasswordErr == "") {

    if (isset($_POST['submit'])) {

        // Performing insert query execution
        $user_id = $_GET['id'];
        $sql = "INSERT INTO useradmin(id, name, email, password) VALUES ('','$Name','$Email','$Password')";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Added Successfully';
        } else {
            $_SESSION['message'] = 'Admin is not Successfully Added';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: viewAdmin.php");
        ob_end_flush();                       // for header() error
        die;
    }
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">User</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Admins</h4>

                </div>
                <div class="card-body">
                    <form action="addAdmin.php" method="post">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Full Name</label>
                                <input type="text" name="name" class="form-control" id="">
                                <?php if ($NameErr != "") {
                                    echo '<span style="color: red">' . '* ' . $NameErr . '</span><br>';
                                } ?>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" id="">
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
                                <input type="submit" name="submit" value="Add Admin" class="btn btn-success" id="">
                                <a class="btn btn-primary" href="viewAdmin.php">Cancel</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

</div>



<?php
include('includes/footer.php');
include('includes/scripts.php');
?>