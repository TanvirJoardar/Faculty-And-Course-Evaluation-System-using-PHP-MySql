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
        <li class="breadcrumb-item">View Students</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Registered Students
                        <a class="btn btn-primary float-end" href="addStudent.php">Add Students</a>
                    </h4>

                </div>
                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Student ID</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select * from user";
                            $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['student_id']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['password']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td><?= $row['date']; ?></td>
                                        <td><a href="editStudent.php?id=<?= $row['id']; ?>" class="btn btn-success">Edit</a></td>
                                        <td>
                                            <form action="deleteStudent.php" method="post">
                                                <button href="editStudent.php" name="delete" value="<?= $row['id']; ?>" class="btn btn-danger">Delete</button>
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