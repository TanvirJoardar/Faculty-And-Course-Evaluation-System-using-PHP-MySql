<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
include('includes/function.php');
include('admin/config/database.php');
$User_data = check_login($connection);
?>

<?php

if (!isset($_POST['adv_course_id']) && !isset($_POST['submit'])) {
    header("Location: index.php");
    die;
}



function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


// insert to database


if (isset($_POST['submit'])) {

    $db_User_ID = test_input($_POST['curr_user']);
    $db_Course_ID = test_input($_POST['course']);
    // $db_Rating = $_POST['radio_status'];              
    // $db_Question_ID = $_POST['question'];             

    $db_Faculty_ID = test_input($_POST['faculty']);
    $db_Course_Feedback = test_input($_POST['c_feedback']);
    $db_Faculty_Feedback = test_input($_POST['f_feedback']);

    $q_sql = "select q_id from question,criteria where question.criteria_cr_id = criteria.cr_id and criteria.criteria_status = 'True' ";   // change criteria

    $q_result = mysqli_query($connection, $q_sql);

    // Performing insert query execution

    foreach ($q_result as $key => $question) {

        $str_r = 'radio_status' . $key;
        $str_q = 'question' . $key;


        $db_Rating = $_POST[$str_r];
        $db_Question_ID = $_POST[$str_q];


        $sql = "INSERT INTO evaluation (id,rating,course_c_id,user_u_id,question_q_id) VALUES ('','$db_Rating','$db_Course_ID','$db_User_ID','$db_Question_ID') ";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Add Evaluation Successfully';
        } else {
            $_SESSION['message'] = 'Add Evaluation is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }
    }

    $f_sql = "INSERT INTO feedback (id,user_u_id,faculty_f_id,course_c_id,course_feedback,faculty_feedback) VALUES ('','$db_User_ID','$db_Faculty_ID','$db_Course_ID','$db_Course_Feedback','$db_Faculty_Feedback') ";

    if (mysqli_query($connection, $f_sql)) {
        $_SESSION['message'] = 'Add Feedback Successfully';
    } else {
        $_SESSION['message'] = 'Add Feedback is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    $q_sql = "UPDATE coursetaken SET adv_status = 'True' WHERE user_u_id = '$db_User_ID' and course_c_id = '$db_Course_ID'";
    if (mysqli_query($connection, $q_sql)) {
        $_SESSION['message'] = 'Update Advising Status Successfully';
    } else {
        $_SESSION['message'] = 'Advising Status is not Update Successfully';
        echo "<br>" . mysqli_error($connection);
    }


    // Close connection
    mysqli_close($connection);

    header("Location: index.php");
    ob_end_flush();                       // for header() error
    die;
}




?>


<div class="py-5">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                include('message.php');   // printing message
                ?>
            </div>

            <div class="col-md-12">
                <?php

                $sm_sql = "select semester.s_name
                        from semester
                        where
                        s_running = 'True' ";

                $sm_result = mysqli_query($connection, $sm_sql);

                $about = mysqli_fetch_assoc($sm_result);



                if (isset($_SESSION['USER_DATA'])) {
                ?>

                    <h1>Student Name: <?= $_SESSION['USER_DATA']['STUDENT_NAME'] ?> </h1>
                    <h4>Student ID: <?= $_SESSION['USER_DATA']['STUDENT_ID'] ?> </h4>
                    <h4>Semester: <?= $about['s_name'] ?> </h4>

                <?php
                }
                ?>


            </div>

            <div class="col-md-12 mt-5">
                <table class="table table-dark table-hover table-striped " border="1" cellspacing="0" cellpadding="0">
                    <?php
                    $curr_student_id = $_SESSION['USER_DATA']['STUDENT_ID'];

                    $Course_id = $_POST['adv_course_id'];

                    $sql = "select c_id, c_name, course.section,faculty.f_name,faculty.f_id,semester.s_name,user.student_id,user.id
                    from course,coursetaken,faculty,semester,user
                    where
                    course.faculty_f_id = faculty.f_id and coursetaken.user_u_id = user.id and coursetaken.course_c_id = course.c_id 
                    and course.semester_s_id = semester.s_id and user.student_id = '$curr_student_id' and course.c_id = '$Course_id' ";

                    $result = mysqli_query($connection, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $All_Info = mysqli_fetch_assoc($result);

                        $Course_Name = $All_Info['c_name'];
                        $Faculty_Name = $All_Info['f_name'];
                        $Section = $All_Info['section'];
                        $Semester = $All_Info['s_name'];
                    } else {
                        $Course_Name = $Faculty_Name = $Section = $Semester = "NO Records";
                    }

                    ?>
                    <form action="advising.php" method="post">
                        <thead>
                            <tr>
                                <th colspan="4" style="text-align:center">
                                    <h3>Evaluation Form For Respective Courses</h3>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupSelect01">Course</label>
                                        <select name="course" class="form-select" id="inputGroupSelect01" required>
                                            <option value="<?= $All_Info['c_id'] ?>"><?= $Course_Name ?></option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupSelect01">Faculty</label>
                                        <select name="faculty" class="form-select" id="inputGroupSelect01" required>
                                            <option value="<?= $All_Info['f_id'] ?>"><?= $Faculty_Name ?></option>

                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupSelect01">Sections</label>
                                        <select name="section" class="form-select" id="inputGroupSelect01">
                                            <option value="1"><?= $Section ?></option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupSelect01">Semester</label>
                                        <select name="semester" class="form-select" id="inputGroupSelect01">
                                            <option value="1"><?= $Semester ?></option>

                                        </select>
                                        <input type="hidden" name="curr_user" value="<?= $All_Info['id'] ?>">
                                    </div>
                                </td>
                            </tr>

                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <table style="text-align:center; vertical-align: middle;" class="table table-dark table-hover table-striped table-bordered">
                                        <tr>
                                            <td style="text-align:left">Questions</td>
                                            <td>Strongly Agree</td>
                                            <td>Agree</td>
                                            <td>Disagree</td>
                                            <td>Strongly Disagree</td>
                                            <td>N/A</td>
                                        </tr>

                                        <?php
                                        // $Criteria = '1';       //  change the criteria
                                        $sql = "select question.q_id,question.question
                                        from question,criteria 
                                        where 
                                        question.criteria_cr_id = criteria.cr_id and criteria.criteria_status = 'True' 
                                        ";

                                        $result = mysqli_query($connection, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            foreach ($result as $key => $question) {

                                        ?>

                                                <tr height="60px">
                                                    <td style="text-align:left">
                                                        <?= $question['question'] ?>
                                                        <input type="hidden" name="<?= 'question' . $key ?>" value="<?= $question['q_id'] ?>">
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="<?= 'radio_status' . $key ?>" id="inlineRadio1" value="5" required>
                                                            <label class="form-check-label" for="inlineRadio1">1</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="<?= 'radio_status' . $key ?>" id="inlineRadio2" value="4">
                                                            <label class="form-check-label" for="inlineRadio2">2</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="<?= 'radio_status' . $key ?>" id="inlineRadio3" value="2">
                                                            <label class="form-check-label" for="inlineRadio3">3</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="<?= 'radio_status' . $key ?>" id="inlineRadio4" value="1">
                                                            <label class="form-check-label" for="inlineRadio4">4</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="<?= 'radio_status' . $key ?>" id="inlineRadio5" value="3">
                                                            <label class="form-check-label" for="inlineRadio5">5</label>
                                                        </div>
                                                    </td>
                                                </tr>

                                        <?php
                                            }
                                        } else {

                                            echo '<tr colspan="6"><td>NO Records</td></tr>';
                                        }

                                        ?>

                                </td>
                            </tr>

                        </tbody>

                </table>
                <table style=" vertical-align: middle;" class="table table-dark table-hover table-striped table-bordered">
                    <thead>

                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                Comment or Feedback About the Course
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <textarea class="form-control" name="c_feedback" placeholder="Write your Feedback" required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                Comment or Feedback About the Faculty
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <textarea class="form-control" name="f_feedback" placeholder="Write your Feedback" required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="col-md-12 mb-3">
                                    <input type="submit" name="submit" value="Submit " class="btn btn-success" id="">
                                    <a class="btn btn-primary" href="index.php">Cancel</a>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                </form>

            </div>
        </div>

    </div>
</div>


<?php
include('includes/footer.php');
?>