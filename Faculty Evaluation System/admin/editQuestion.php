<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
?>


<?php

// Variable
$Q_Name = $Q_NameErr = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Name validation
    if (empty($_POST['q_name'])) {
        $Q_NameErr = "Question is required";
    } else {
        $Q_Name = test_input($_POST["q_name"]);

        $sql = "select question from question where question = '$Q_Name'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $db_s_name = mysqli_fetch_assoc($result);
            if ($db_s_name['question'] == $Q_Name) {
                $Q_NameErr = "This Question is Already Exists";
            }
        }
    }
}



function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// insert to database

if ($Q_NameErr == "") {

    if (isset($_POST['submit'])) {
        $Criteria = $_POST["criteria"];

        // Performing insert query execution
        $user_id = $_GET['id'];
        $sql = "UPDATE question SET question = '$Q_Name',criteria_cr_id = '$Criteria' WHERE q_id='$user_id'";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Update Question Successfully';
        } else {
            $_SESSION['message'] = 'Update Question is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: viewQuestion.php");
        ob_end_flush();                       // for header() error
        die;
    }
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Question</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Question</h4>

                </div>
                <div class="card-body">

                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $sql = "select question.question,criteria.val_criteria
                            from 
                            question,criteria
                            where 
                            question.criteria_cr_id = criteria.cr_id and question.q_id='$user_id'";
                        $result = mysqli_query($connection, $sql);

                        $select_cr = "select * from criteria";
                        $select_cr_result = mysqli_query($connection, $select_cr);

                        if (mysqli_num_rows($result) > 0) {

                            foreach ($result as $row) {

                    ?>
                                <!--  need to change action-->
                                <form action="editQuestion.php?id=<?= $user_id; ?>" method="post">
                                    <div class="row">

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="">Question</label>
                                                <input type="text" name="q_name" value="<?= $row['question']; ?>" class="form-control" id="">
                                                <?php if ($Q_NameErr != "") {
                                                    echo '<span style="color: red">' . '* ' . $Q_NameErr . '</span><br>';
                                                } ?>
                                            </div>
                                            <div class="input-group col-md-12 mb-3">
                                                <label class="input-group-text" for="inputGroupSelect01">Criteria</label>
                                                <select name="criteria" class="form-select" id="inputGroupSelect01" required>
                                                    <option value=""><?= $row['val_criteria'] . " (Current)" ?></option>
                                                    <?php
                                                    foreach ($select_cr_result as $criteria) {
                                                    ?>
                                                        <option value="<?= $criteria['cr_id'] ?>"><?= $criteria['val_criteria'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <input type="submit" name="submit" value="Update Question " class="btn btn-success" id="">
                                                <a class="btn btn-primary" href="viewQuestion.php">Cancel</a>
                                            </div>
                                        </div>

                                </form>

                            <?php
                            }
                        } else {
                            ?>
                            <h4>No Record Found</h4>
                    <?php
                        }
                    }

                    ?>

                </div>
            </div>
        </div>

    </div>

</div>



<?php
include('includes/footer.php');
include('includes/scripts.php');
?>