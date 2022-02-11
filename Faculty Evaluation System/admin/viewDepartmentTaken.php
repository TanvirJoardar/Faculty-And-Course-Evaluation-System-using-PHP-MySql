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
        <li class="breadcrumb-item">Department Taken</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>View Department Taken
                        <a class="btn btn-primary float-end" href="addDepartmenttaken.php">Add Department Taken</a>
                    </h4>

                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student ID</th>
                                <th>Department Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select departmenttaken.dt_id,department.d_name,user.student_id 
                            from 
                            departmenttaken,user,department
                            where
                            departmenttaken.user_u_id = user.id and departmenttaken.department_d_id = department.d_id
                            ";
                            $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['dt_id']; ?></td>
                                        <td><?= $row['student_id']; ?></td>
                                        <td><?= $row['d_name']; ?></td>
                                        <td><a href="editDepartmentTaken.php?id=<?= $row['dt_id']; ?>" class="btn btn-success">Edit</a></td>
                                        <td>
                                            <form action="allDelete.php" method="post">
                                                <button href="editDepartmentTaken.php" name="deleteDepartmentTaken" value="<?= $row['dt_id']; ?>" class="btn btn-danger">Delete</button>
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