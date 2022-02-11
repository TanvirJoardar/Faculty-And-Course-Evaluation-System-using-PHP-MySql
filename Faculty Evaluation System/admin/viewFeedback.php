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
        <li class="breadcrumb-item">Feedback</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>View Feedback
                    </h4>

                </div>
                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Feedback</th>
                                <th>Faculty Feedback</th>
                                <th>course</th>
                                <th>Faculty</th>
                                <th>Student ID</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select feedback.id,feedback.course_feedback,feedback.faculty_feedback,course.c_name,faculty.f_name,user.student_id
                             from feedback,course,faculty,user
                             where feedback.course_c_id = course.c_id and feedback.faculty_f_id = faculty.f_id and feedback.user_u_id = user.id
                             ";
                            $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['course_feedback']; ?></td>
                                        <td><?= $row['faculty_feedback']; ?></td>
                                        <td><?= $row['c_name']; ?></td>
                                        <td><?= $row['f_name']; ?></td>
                                        <td><?= $row['student_id']; ?></td>
                                        <td>
                                            <form action="allDelete.php" method="post">
                                                <button href="viewFeedback.php" name="deleteFeedback" value="<?= $row['id']; ?>" class="btn btn-danger">Delete</button>
                                            </form>

                                        </td>
                                    </tr>


                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6">No Record Found</td>
                                </tr>
                            <?php
                            }

                            ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

</div>



<?php
include('includes/footer.php');
include('includes/scripts.php');
?>