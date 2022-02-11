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
        <li class="breadcrumb-item">User</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Registered Admins
                        <a class="btn btn-primary float-end" href="addAdmin.php">Add Admin</a>
                    </h4>

                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
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

                            $sql = "select * from useradmin";
                            $result = mysqli_query($connection, $sql);

                            $userCount = "select count('id') from useradmin";
                            $result_userCount = mysqli_query($connection, $userCount);
                            $result_userCount = mysqli_fetch_assoc($result_userCount);

                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['password']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td><?= $row['date']; ?></td>
                                        <td><a href="editAdmin.php?id=<?= $row['id']; ?>" class="btn btn-success">Edit</a></td>
                                        <?php
                                        if ($result_userCount) {
                                            if ($result_userCount["count('id')"] > 1) {
                                        ?>
                                                <td>
                                                    <form action="deleteAdmin.php" method="post">
                                                        <button href="editAdmin.php" name="delete" value="<?= $row['id']; ?>" class="btn btn-danger">Delete</button>
                                                    </form>

                                                </td>

                                        <?php
                                            } else {
                                                echo '<td><button class="btn btn-danger">Last User</button></td>';
                                            }
                                        }
                                        ?>

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