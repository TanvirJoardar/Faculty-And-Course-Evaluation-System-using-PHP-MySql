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
        <li class="breadcrumb-item">View Question</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <?php
        $select_cr = "SELECT cr_id,val_criteria from criteria";
        $select_cr_result = mysqli_query($connection, $select_cr);

        if (isset($_POST['val_cri'])) {
            $Curr_criteria = $_POST['val_cri'];

            $current_cr = "SELECT val_criteria from criteria where cr_id = '$Curr_criteria'";
            $current_cr_result = mysqli_query($connection, $current_cr);
            $current_cr_result = mysqli_fetch_assoc($current_cr_result);
        } else {
            $Curr_criteria = 'Choose Criteria';
        }


        ?>


        <form action="viewQuestionCriteria.php" method="post">
            <div class="col-md-12">
                <div class="input-group col-md-12 mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Question Criteria</label>
                    <select name="val_cri" class="form-select" id="inputGroupSelect01" required>
                        <option value=""><?= isset($current_cr_result) ? $current_cr_result['val_criteria'] . ' (Current)' : $Curr_criteria ?></option>
                        <?php
                        foreach ($select_cr_result as $criteria) {
                        ?>
                            <option value="<?= $criteria['cr_id'] ?>"><?= $criteria['val_criteria'] ?></option>
                        <?php
                        }
                        ?>
                    </select>


                </div>
            </div>
            <div class="col-md-12 mb-3">
                <input type="submit" name="submit" value="View" class="btn btn-success" id="">
            </div>
        </form>


        <?php

        if (isset($_POST['submit'])) {

            $Curr_criteria = $_POST['val_cri'];

            $sql_cr = "select question,val_criteria 
            from 
            question,criteria
            where 
            question.criteria_cr_id=criteria.cr_id and criteria.val_criteria = '$Curr_criteria'
            ";

            $result_cr = mysqli_query($connection, $sql_cr);

        ?>

            <div class="col-md-12 mt-5 mb-5 ">
                <p style="text-align: justify;" class="fs-5 bg-light p-3">Meaningful input from students is essential for improving courses. One of the most common indirect course assessment methods is the course evaluation survey. In addition to providing useful information for improving courses, course evaluations provide an opportunity for students to reflect and provide feedback on their own learning.</p>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Criteria Wise Question View
                        </h4>

                    </div>
                    <div class="card-body" style="overflow-x:auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Question</th>
                                    <th>Criteria</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (mysqli_num_rows($result_cr) > 0) {

                                    foreach ($result_cr as $idx => $row) {
                                ?>
                                        <tr>
                                            <td><?= $idx + 1; ?></td>
                                            <td><?= $row['question']; ?></td>
                                            <td><?= $row['val_criteria']; ?></td>

                                    <?php

                                    }
                                } else {
                                    echo "<td colspan = '3'>No Questions</td>";
                                }

                                    ?>

                            </tbody>
                        </table>

                    </div>
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