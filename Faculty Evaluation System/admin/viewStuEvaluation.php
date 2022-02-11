<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
ob_end_flush();                                 // for header() error
include('page.php');
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">View Student Evaluation</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <?php
        $select_sid = "SELECT id,student_id from user";
        $select_sid_result = mysqli_query($connection, $select_sid);

        if (isset($_POST['sid'])) {
            $Curr_Stu_ID = $_POST['sid'];

            $current_sid = "SELECT student_id from user where id = '$Curr_Stu_ID'";
            $current_sid_result = mysqli_query($connection, $current_sid);
            $current_sid_result = mysqli_fetch_assoc($current_sid_result);
        } else {
            $Curr_Stu_ID = 'Choose Student ID';
        }


        ?>


        <form action="viewStuEvaluation.php" method="post">
            <div class="col-md-12">
                <div class="input-group col-md-12 mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Student ID</label>
                    <select name="sid" class="form-select" id="inputGroupSelect01" required>
                        <option value=""><?= isset($current_sid_result) ? $current_sid_result['student_id'] . ' (Current)' : $Curr_Stu_ID ?></option>
                        <?php
                        foreach ($select_sid_result as $sid) {
                        ?>
                            <option value="<?= $sid['id'] ?>"><?= $sid['student_id'] ?></option>
                        <?php
                        }
                        ?>
                    </select>



                </div>
            </div>
            <div class="col-md-12 mb-3">
                <input type="checkbox" name="sem_all" id="check" <?php echo isset($_POST['sem_all']) ? 'checked' : 'unchecked' ?>>
                <label for="check">Current Semester</label>
            </div>
            <div class="col-md-12 mb-3">
                <input type="submit" name="submit" value="View" class="btn btn-success" id="">
            </div>
        </form>


        <?php

        if (isset($_POST['submit'])) {


        ?>

            <div class="col-md-12 mt-5 mb-5 ">
                <p style="text-align: justify;" class="fs-5 bg-light p-3">Meaningful input from students is essential for improving courses. One of the most common indirect course assessment methods is the course evaluation survey. In addition to providing useful information for improving courses, course evaluations provide an opportunity for students to reflect and provide feedback on their own learning.</p>
            </div>

            <div class="col-md-12 mt-5">
                <h1>Advising Status</h1>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Name</th>
                                <th>Section</th>
                                <th>Semester</th>
                                <th>Faculty</th>
                                <th>Advising Status</th>
                                <th>Advising</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $Curr_Stu_ID = $_POST['sid'];

                            if (isset($_POST['sem_all'])) {
                                $sql = "select c_id, c_name, course.section,faculty.f_name,semester.s_name,user.student_id,coursetaken.adv_status,coursetaken.course_c_id
                                from course,coursetaken,faculty,semester,user
                                where
                                course.faculty_f_id = faculty.f_id and coursetaken.user_u_id = user.id and coursetaken.course_c_id = course.c_id 
                                and course.semester_s_id = semester.s_id and semester.s_running = 'True' and user.id = '$Curr_Stu_ID' ";
                            } else {
                                $sql = "select c_id, c_name, course.section,faculty.f_name,semester.s_name,user.student_id,coursetaken.adv_status,coursetaken.course_c_id
                                from course,coursetaken,faculty,semester,user
                                where
                                course.faculty_f_id = faculty.f_id and coursetaken.user_u_id = user.id and coursetaken.course_c_id = course.c_id 
                                and course.semester_s_id = semester.s_id and user.id = '$Curr_Stu_ID' ";
                            }



                            $result = mysqli_query($connection, $sql);


                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $key => $row) {
                            ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $row['c_name']; ?></td>
                                        <td><?= $row['section']; ?></td>
                                        <td><?= $row['s_name']; ?></td>
                                        <td><?= $row['f_name']; ?></td>
                                        <td><?= $row['adv_status']; ?></td>

                                        <?php
                                        if ($row['adv_status'] == 'True') {
                                        ?>
                                            <td>
                                                <form action="viewStuEvaluationResult.php" method="post">
                                                    <button href="#" name="eval_course_id" value="<?= $row['c_id']; ?>" class="btn btn-success">View Evaluation</button>
                                                    <input type="hidden" name="sid" value="<?= $row['student_id']; ?>">
                                                </form>
                                            </td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><a class="btn btn-success">Not Evaluated</a></td>
                                        <?php
                                        }

                                        ?>


                                    </tr>


                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">No Record Found</td>
                                </tr>
                            <?php
                            }

                            ?>

                        </tbody>
                    </table>

                </div>

            </div>

        <?php

        }

        ?>
    </div>

</div>


<?php
include('includes/footer.php');
include('includes/scripts.php');
?>