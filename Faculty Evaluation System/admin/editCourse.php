<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
?>


<?php

// Variable
$C_Name = $C_NameErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Name validation
    if (empty($_POST['c_name'])) {
        $C_NameErr = "Course Name is required";
    } else {
        $C_Name = test_input($_POST["c_name"]);
        $S_Name = $_POST['section'];
        $D_Name = $_POST['department'];

        $sql = "select c_name from course where c_name = '$C_Name' and section = '$S_Name' and department_d_id = '$D_Name'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $db_c_val = mysqli_fetch_assoc($result);
            if ($db_c_val['c_name'] == $C_Name) {
                $C_NameErr = "This Course Name, Section and Department Name is Already Exists";
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
if ($C_NameErr == "") {

    if (isset($_POST['submit'])) {

        // $C_name = $_POST['c_name'];
        $Section = $_POST['section'];
        $Faculty = $_POST['faculty'];
        $Department = $_POST['department'];
        $Semester = $_POST['semester'];



        // Performing insert query execution
        $user_id = $_GET['id'];
        $sql = "UPDATE course SET c_name = '$C_Name',section = '$Section', faculty_f_id = '$Faculty',department_d_id = '$Department',semester_s_id = '$Semester' WHERE c_id='$user_id'";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Update Course info Successfully';
        } else {
            $_SESSION['message'] = 'Update Course info is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: viewCourse.php");
        ob_end_flush();                       // for header() error
        die;
    }
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Edit Courses</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Courses Info</h4>

                </div>
                <div class="card-body">

                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        // $sql = "select * from user where c_id='$user_id'";
                        $sql = "select c_id,c_name,section,course.date,f_name, d_name, s_name 
                            from 
                            course,department,semester,faculty 
                            where 
                            course.faculty_f_id=faculty.f_id and course.department_d_id = department.d_id and course.semester_s_id = semester.s_id and course.c_id='$user_id'";
                        $result = mysqli_query($connection, $sql);
                        $select_f = "select f_id, f_name, d_name from faculty,department where faculty.department_d_id = department.d_id";
                        $select_d = "select d_id, d_name from department";
                        $select_s = "select s_id, s_name from semester";
                        $select_f_result = mysqli_query($connection, $select_f);
                        $select_d_result = mysqli_query($connection, $select_d);
                        $select_s_result = mysqli_query($connection, $select_s);

                        if (mysqli_num_rows($result) > 0) {

                            foreach ($result as $row) {

                    ?>
                                <!--  need to change action-->
                                <form action="editCourse.php?id=<?= $user_id; ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="">Course Name</label>
                                            <input type="text" name="c_name" value="<?= $row['c_name']; ?>" class="form-control" id="">
                                            <?php if ($C_NameErr != "") {
                                                echo '<div class="input-group col-md-12 mb-3"><span style="color: red">' . '* ' . $C_NameErr . '</span></div>';
                                            } ?>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="">Section</label>
                                            <input type="text" name="section" value="<?= $row['section']; ?>" class="form-control" id="">

                                        </div>

                                        <div class="input-group col-md-12 mb-3">
                                            <label class="input-group-text" for="inputGroupSelect01">Faculty</label>
                                            <select name="faculty" class="form-select" id="inputGroupSelect01" required>
                                                <option value=""><?= $row['f_name'] . ' (' . $row['d_name'] . ' )' . ' (Current)'  ?></option>
                                                <?php
                                                foreach ($select_f_result as $faculty) {
                                                ?>
                                                    <option value="<?= $faculty['f_id'] ?>"><?= $faculty['f_name'] . ' (' . $faculty['d_name'] . ' )' ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="input-group col-md-12 mb-3">
                                            <label class="input-group-text" for="inputGroupSelect01">Department</label>
                                            <select name="department" class="form-select" id="inputGroupSelect01" required>
                                                <option value=""><?= $row['d_name'] . ' (Current)'  ?></option>
                                                <?php
                                                foreach ($select_d_result as $department) {
                                                ?>
                                                    <option value="<?= $department['d_id'] ?>"><?= $department['d_name'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="input-group col-md-12 mb-3">
                                            <label class="input-group-text" for="inputGroupSelect01">Semester</label>
                                            <select name="semester" class="form-select" id="inputGroupSelect01" required>
                                                <option value=""><?= $row['s_name'] . ' (Current)'  ?></option>
                                                <?php
                                                foreach ($select_s_result as $semester) {
                                                ?>
                                                    <option value="<?= $semester['s_id'] ?>"><?= $semester['s_name'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <input type="submit" name="submit" value="Update Student" class="btn btn-success" id="">
                                            <a class="btn btn-primary" href="viewCourse.php">Cancel</a>
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