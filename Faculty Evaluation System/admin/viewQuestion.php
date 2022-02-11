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
        <li class="breadcrumb-item">Question</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>View Question
                        <a class="btn btn-primary float-end" href="addQuestion.php">Add Question</a>
                    </h4>

                </div>
                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Criteria</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select q_id,question,criteria.val_criteria from question,criteria where question.criteria_cr_id = criteria.cr_id";
                            $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['q_id']; ?></td>
                                        <td><?= $row['question']; ?></td>
                                        <td><?= $row['val_criteria']; ?></td>
                                        <td><a href="editQuestion.php?id=<?= $row['q_id']; ?>" class="btn btn-success">Edit</a></td>
                                        <td>
                                            <form action="allDelete.php" method="post">
                                                <button href="editQuestion.php" name="deleteQuestion" value="<?= $row['q_id']; ?>" class="btn btn-danger">Delete</button>
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