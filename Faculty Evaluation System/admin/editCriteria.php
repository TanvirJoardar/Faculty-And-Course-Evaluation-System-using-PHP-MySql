<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
?>


<?php

// Variable
$Cr_Name = $Cr_NameErr = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Name validation
    if (empty($_POST['cr_val'])) {
        $Cr_NameErr = "Criteria Value is required";
    } else {
        $Cr_Name = test_input($_POST["cr_val"]);

        $user_id = $_GET['id'];
        $sql = "select val_criteria from criteria where val_criteria = '$Cr_Name' and cr_id != '$user_id'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $db_cr_val = mysqli_fetch_assoc($result);
            if ($db_cr_val['val_criteria'] == $Cr_Name) {
                $Cr_NameErr = "This Criteria Value is Already Exists";
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

if ($Cr_NameErr == "") {


    if (isset($_POST['submit'])) {


        $Cr_Status = $_POST['cr_status'];

        // Performing insert query execution
        $user_id = $_GET['id'];

        if ($Cr_Status == 'True') {
            $Cr_Status_excp = 'False';
            $sql_excp = "UPDATE criteria SET criteria_status = '$Cr_Status_excp' WHERE cr_id !='$user_id'";

            if (mysqli_query($connection, $sql_excp)) {
                $_SESSION['message'] = 'Update Criteria Exception Successfully';
            } else {
                $_SESSION['message'] = 'Update Criteria Exception is not Successfull';
                echo "<br>" . mysqli_error($connection);
            }
        }

        $sql = "UPDATE criteria SET val_criteria = '$Cr_Name',criteria_status = '$Cr_Status' WHERE cr_id='$user_id'";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Update Semester Successfully';
        } else {
            $_SESSION['message'] = 'Update Semester is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: viewCriteria.php");
        ob_end_flush();                       // for header() error
        die;
    }
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Criteria</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Criteria</h4>

                </div>
                <div class="card-body">

                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $sql = "select criteria.cr_id,criteria.val_criteria,criteria.criteria_status from criteria where criteria.cr_id='$user_id'";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            foreach ($result as $row) {

                    ?>
                                <!--  need to change action-->
                                <form action="editCriteria.php?id=<?= $user_id; ?>" method="post">
                                    <div class="row">

                                        <div class="input-group col-md-12 mb-3">
                                            <label class="input-group-text" for="inputGroupSelect01">Criteria Value</label>
                                            <select name="cr_val" class="form-select" id="inputGroupSelect01" required>
                                                <option value=""><?= $row['val_criteria']; ?> (current)</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>

                                            </select>
                                            <?php if ($Cr_NameErr != "") {
                                                echo '<div class="input-group col-md-12 mb-3"><span style="color: red">' . '* ' . $Cr_NameErr . '</span></div><br>';
                                            } ?>
                                        </div>
                                        <div class="input-group col-md-12 mb-3">
                                            <label class="input-group-text" for="inputGroupSelect01">Criteria Status</label>
                                            <select name="cr_status" class="form-select" id="inputGroupSelect01" required>
                                                <option value=""><?= $row['criteria_status']; ?> (current)</option>
                                                <option value="True">True</option>
                                                <option value="False">False</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <input type="submit" name="submit" value="Update Criteria" class="btn btn-success" id="">
                                            <a class="btn btn-primary" href="viewCriteria.php">Cancel</a>
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