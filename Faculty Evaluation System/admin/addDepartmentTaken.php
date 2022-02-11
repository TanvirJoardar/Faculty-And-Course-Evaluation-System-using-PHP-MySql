<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
?>


<?php
// Variable
$department_id = $Student_id = $department_idErr = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $department_id = test_input($_POST['d_name']);
    $Student_id = test_input($_POST['stdid']);

    // Name validation
    if (empty($_POST['d_name'])) {
        $department_idErr = "Department Name is required";
    } else {
        $department_id = test_input($_POST["d_name"]);

        $sql = "select department_d_id from departmenttaken where department_d_id = '$department_id' and user_u_id = '$Student_id'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $db_d_name = mysqli_fetch_assoc($result);
            if ($db_d_name['department_d_id'] == $department_id) {
                $department_idErr = "This Student and Department is Already Exists";
            }
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

if ($department_idErr == "") {

    if (isset($_POST['submit'])) {

        // $department_id = $_POST['d_name'];
        // $Student_id = $_POST['stdid'];

        // Performing insert query execution
        $user_id = $_GET['id'];
        $sql = "INSERT INTO departmenttaken (dt_id, department_d_id , user_u_id) VALUES ('','$department_id','$Student_id')";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Add Department Taken info Successfully';
        } else {
            $_SESSION['message'] = 'Add Department Taken is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: viewDepartmentTaken.php");
        ob_end_flush();                       // for header() error
        die;
    }
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Department Taken</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Department Taken</h4>

                </div>
                <div class="card-body">

                    <?php

                    $select_s = "select id, student_id from user";
                    $select_d = "select d_id, d_name from department";

                    $select_s_result = mysqli_query($connection, $select_s);
                    $select_d_result = mysqli_query($connection, $select_d);

                    ?>
                    <!--  need to change action-->
                    <form action="addDepartmentTaken.php" method="post">
                        <div class="row">


                            <div class="input-group col-md-12 mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Student ID</label>
                                <select name="stdid" class="form-select" id="inputGroupSelect01" required>
                                    <?php
                                    foreach ($select_s_result as $student) {
                                    ?>
                                        <option value="<?= $student['id'] ?>"><?= $student['student_id'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <?php if ($department_idErr != "") {
                                    echo '<div class="input-group col-md-12 mb-3"><span style="color: red">' . '* ' . $department_idErr . '</span></div>';
                                } ?>
                            </div>

                            <div class="input-group col-md-12 mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Department Name</label>
                                <select name="d_name" class="form-select" id="inputGroupSelect01" required>
                                    <?php
                                    foreach ($select_d_result as $department) {
                                    ?>
                                        <option value="<?= $department['d_id'] ?>"><?= $department['d_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <input type="submit" name="submit" value="Add Department Taken " class="btn btn-success" id="">
                                <a class="btn btn-primary" href="viewDepartmentTaken.php">Cancel</a>
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