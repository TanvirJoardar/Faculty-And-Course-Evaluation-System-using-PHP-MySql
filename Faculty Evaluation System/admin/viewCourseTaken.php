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
        <li class="breadcrumb-item">View Course Taken</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Enrolled Courses
                        <a class="btn btn-primary float-end" href="addCourseTaken.php">Enroll Courses</a>
                    </h4>

                </div>
                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Name</th>
                                <th>Student ID</th>
                                <th>Advising Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select coursetaken.id,coursetaken.adv_status,course.c_name,user.student_id,course.section 
                            from 
                            course,coursetaken,user 
                            where 
                            coursetaken.course_c_id=course.c_id and coursetaken.user_u_id = user.id";
                            $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['c_name'] . "_Sec-" . $row['section']; ?></td>
                                        <td><?= $row['student_id']; ?></td>
                                        <td><?= $row['adv_status']; ?></td>

                                        <?php
                                        if ($row['adv_status'] == 'False') {
                                        ?>
                                            <td><a href="editCourseTaken.php?id=<?= $row['id']; ?>" class="btn btn-success">Edit</a></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><a class="btn btn-success">Not Editable</a></td>
                                        <?php
                                        }

                                        ?>
                                        <td>
                                            <form action="allDelete.php" method="post">
                                                <button href="editCourseTaken.php" name="deleteCourseTaken" value="<?= $row['id']; ?>" class="btn btn-danger">Delete</button>
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