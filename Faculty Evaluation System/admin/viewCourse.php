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
        <li class="breadcrumb-item">View Course</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Courses
                        <a class="btn btn-primary float-end" href="addCourse.php">Add Courses</a>
                    </h4>

                </div>
                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Name</th>
                                <th>Section</th>
                                <th>Faculty</th>
                                <th>Department</th>
                                <th>Semester</th>
                                <th>Date</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select c_id,c_name,section,course.date,f_name, d_name, s_name 
                            from 
                            course,department,semester,faculty 
                            where 
                            course.faculty_f_id=faculty.f_id and course.department_d_id = department.d_id and course.semester_s_id = semester.s_id";
                            $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['c_id']; ?></td>
                                        <td><?= $row['c_name']; ?></td>
                                        <td><?= $row['section']; ?></td>
                                        <td><?= $row['f_name']; ?></td>
                                        <td><?= $row['d_name']; ?></td>
                                        <td><?= $row['s_name']; ?></td>
                                        <td><?= $row['date']; ?></td>
                                        <td><a href="editCourse.php?id=<?= $row['c_id']; ?>" class="btn btn-success">Edit</a></td>
                                        <td>
                                            <form action="allDelete.php" method="post">
                                                <button href="editCourse.php" name="deleteCourse" value="<?= $row['c_id']; ?>" class="btn btn-danger">Delete</button>
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