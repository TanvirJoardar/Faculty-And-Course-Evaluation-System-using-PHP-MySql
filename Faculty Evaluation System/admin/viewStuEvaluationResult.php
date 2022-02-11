<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
ob_end_flush();                                 // for header() error
include('page.php');

$result = '';

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Evaluation Result</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <div class="col-md-12">

            <?php
            if (isset($_POST['eval_course_id'])) {

                $Curr_course_id = $_POST['eval_course_id'];
                $Curr_Student_id = $_POST['sid'];
            }

            $sql = "SELECT question,rating,semester.s_name,course.c_name,user.id 
            from evaluation,course,user,question,semester
            WHERE
            evaluation.course_c_id = course.c_id AND evaluation.user_u_id = user.id AND evaluation.question_q_id = question.q_id AND course.semester_s_id = semester.s_id AND course.c_id = '$Curr_course_id' AND user.student_id = '$Curr_Student_id'";

            $result = mysqli_query($connection, $sql);

            $se_result = mysqli_fetch_assoc($result);

            $fed_sql = "SELECT course_feedback,faculty_feedback 
            from feedback,user
            WHERE
            feedback.user_u_id = user.id and course_c_id = '$Curr_course_id' AND user.student_id = '$Curr_Student_id'";

            $fed_result = mysqli_query($connection, $fed_sql);

            $fed_result = mysqli_fetch_assoc($fed_result);



            if (isset($_POST['eval_course_id'])) {
            ?>
                <h1>Student ID: <?= $_POST['sid'] ?> </h1>
                <h4>Course Name: <?= $se_result['c_name'] ?> </h4>
                <h4>Semester: <?= $se_result['s_name'] ?> </h4>

            <?php
            }
            ?>
        </div>

        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h4>View Evaluation Result
                    </h4>

                </div>
                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // if (isset($_POST['eval_course_id'])) {

                            //     $Curr_course_id = $_POST['eval_course_id'];
                            //     $Curr_Student_id = $_POST['sid'];
                            // }

                            // $sql = "SELECT question,rating 
                            // from evaluation,course,user,question
                            // WHERE
                            // evaluation.course_c_id = course.c_id AND evaluation.user_u_id = user.id AND evaluation.question_q_id = question.q_id AND course.c_id = '$Curr_course_id' AND user.student_id = '$Curr_Student_id'";
                            // $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $ind => $row) {
                            ?>
                                    <tr>
                                        <td><?= $ind + 1 ?></td>
                                        <td><?= $row['question']; ?></td>
                                        <td><?= $row['rating']; ?></td>
                                    </tr>


                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="3">No Record Found</td>
                                </tr>
                            <?php
                            }

                            ?>

                            <tr>
                                <th colspan="2">Course Feedback</th>
                                <th><?= $fed_result['course_feedback'] ?></th>
                            </tr>
                            <tr>
                                <th colspan="2">Faculty Feedback</th>
                                <th><?= $fed_result['faculty_feedback'] ?></th>
                            </tr>

                        </tbody>
                    </table>
                    <form action="viewStuEvaluation.php" method="post">
                        <input type="hidden" name="sid" value="<?= $se_result['id'] ?>">
                        <input class="btn btn-success" type="submit" name="submit" value="Cancel">
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