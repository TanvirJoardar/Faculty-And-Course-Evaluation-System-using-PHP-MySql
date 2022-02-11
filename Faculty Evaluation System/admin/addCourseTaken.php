<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
?>


<?php
// Variable
$Course_id = $Student_id = $Course_id_Err = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Name validation
    if (empty($_POST['c_name'])) {
        $Course_id_Err = "Course Name is required";
    } else {
        $Course_id = test_input($_POST['c_name']);
        $Student_id = test_input($_POST['stdid']);

        $sql = "select course_c_id from coursetaken where course_c_id = '$Course_id' and user_u_id = '$Student_id'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $db_c_val = mysqli_fetch_assoc($result);
            if ($db_c_val['course_c_id'] == $Course_id) {
                $Course_id_Err = "This Course Name and Student Name is Already Exists";
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

if ($Course_id_Err == "") {


    if (isset($_POST['submit'])) {

        // $Course_id = $_POST['c_name'];
        // $Student_id = $_POST['stdid'];

        // Performing insert query execution
        $sql = "INSERT INTO coursetaken(id, course_c_id,user_u_id) VALUES ('','$Course_id','$Student_id')";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Enrolled Course Taken Successfully';
        } else {
            $_SESSION['message'] = 'Enrolled Course Taken is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: viewCourseTaken.php");
        ob_end_flush();                       // for header() error
        die;
    }
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Enrolled Courses Taken</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Enrolled Course Taken</h4>

                </div>
                <div class="card-body">

                    <?php
                    // $select_s = "select id, student_id from user";
                    // $select_c = "select c_id, c_name,section from course";

                    $select_s = "select id, student_id, department.d_name from user,departmenttaken,department where user.id = departmenttaken.user_u_id and departmenttaken.department_d_id = department.d_id";
                    $select_c = "select c_id, c_name,section,department.d_name from course,department where course.department_d_id = department.d_id";

                    $select_s_result = mysqli_query($connection, $select_s);
                    $select_c_result = mysqli_query($connection, $select_c);

                    ?>
                    <!--  need to change action-->
                    <form action="AddCourseTaken.php" method="post">
                        <div class="row">

                            <div class="input-group col-md-12 mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Course Name</label>
                                <select name="c_name" class="form-select" id="inputGroupSelect01" required>
                                    <?php
                                    foreach ($select_c_result as $course) {
                                    ?>
                                        <option value="<?= $course['c_id'] ?>"><?= $course['c_name'] . "_Sec-" . $course['section'] . "_" . $course['d_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <?php if ($Course_id_Err != "") {
                                    echo '<div class="input-group col-md-12 mb-3"><span style="color: red">' . '* ' . $Course_id_Err . '</span></div>';
                                } ?>
                            </div>
                            <div class="input-group col-md-12 mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Student ID</label>
                                <select name="stdid" class="form-select" id="inputGroupSelect01" required>
                                    <?php
                                    foreach ($select_s_result as $student) {
                                    ?>
                                        <option value="<?= $student['id'] ?>"><?= $student['student_id'] . "_" . $student['d_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <input type="submit" name="submit" value="Add Enrolled Course " class="btn btn-success" id="">
                                <a class="btn btn-primary" href="viewCourseTaken.php">Cancel</a>
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