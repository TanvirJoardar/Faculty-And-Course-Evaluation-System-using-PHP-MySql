<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
include('includes/function.php');
include('admin/config/database.php');
$User_data = check_login($connection);
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

                $curr_student_id = $_SESSION['USER_DATA']['STUDENT_ID'];
                $sql = "select c_id, c_name, course.section,faculty.f_name,semester.s_name,user.student_id,coursetaken.adv_status,coursetaken.course_c_id
                        from course,coursetaken,faculty,semester,user
                        where
                        course.faculty_f_id = faculty.f_id and coursetaken.user_u_id = user.id and coursetaken.course_c_id = course.c_id 
                        and course.semester_s_id = semester.s_id and semester.s_running = 'True' and user.student_id = '$curr_student_id' ";

                $result = mysqli_query($connection, $sql);

                $about = mysqli_fetch_assoc($result);
                // print_r($about);



                if (isset($_SESSION['USER_DATA'])) {
                ?>

                    <h1>Student Name: <?= $_SESSION['USER_DATA']['STUDENT_NAME'] ?> </h1>
                    <h4>Student ID: <?= $_SESSION['USER_DATA']['STUDENT_ID'] ?> </h4>
                    <h4>Semester: <?= isset($about['s_name']) ? $about['s_name'] : 'Not Registered' ?> </h4>

                <?php
                }
                ?>



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
                                        if ($row['adv_status'] == 'False') {
                                        ?>
                                            <td>
                                                <form action="advising.php" method="post">
                                                    <button href="editFaculty.php" name="adv_course_id" value="<?= $row['c_id']; ?>" class="btn btn-success">Go For Advising</button>
                                                </form>
                                            </td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><a class="btn btn-success">Completed</a></td>
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


        </div>

    </div>
</div>


<?php
include('includes/footer.php');
?>