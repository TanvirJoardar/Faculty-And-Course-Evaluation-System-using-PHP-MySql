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
        <li class="breadcrumb-item">Evaluation</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>View Evaluation
                    </h4>

                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student ID</th>
                                <th>Course</th>
                                <th>Question</th>
                                <th>Rating</th>
                                <th>Date</th>

                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select evaluation.id,user.student_id,course.c_name,question.question,evaluation.rating,evaluation.date
                             from evaluation,course,user,question
                             where evaluation.course_c_id = course.c_id and evaluation.user_u_id = user.id and evaluation.question_q_id = question.q_id 
                             ";
                            $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['student_id']; ?></td>
                                        <td><?= $row['c_name']; ?></td>
                                        <td><?= $row['question']; ?></td>
                                        <td><?= $row['rating']; ?></td>
                                        <td><?= $row['date']; ?></td>

                                        <td>
                                            <form action="allDelete.php" method="post">
                                                <button href="viewEvaluation.php" name="deleteEvaluation" value="<?= $row['id']; ?>" class="btn btn-danger">Delete</button>
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