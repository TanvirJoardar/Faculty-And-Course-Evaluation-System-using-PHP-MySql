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

        $sql = "select val_criteria from criteria where val_criteria = '$Cr_Name'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $db_cr_val = mysqli_fetch_assoc($result);
            if ($db_cr_val['val_criteria'] == $Cr_Name) {
                $Cr_NameErr = "This Criteria Value is Already Exists or Full";
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

        $user_id = $_GET['id'];

        $sql = "INSERT INTO criteria (cr_id,val_criteria) VALUES ('','$Cr_Name')";

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
                    <h4>Add Criteria</h4>

                </div>
                <div class="card-body">

                    <!--  need to change action-->
                    <form action="addCriteria.php" method="post">
                        <div class="row">

                            <div class="input-group col-md-12 mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Criteria Value</label>
                                <select name="cr_val" class="form-select" id="inputGroupSelect01" required>
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
                                    <option value="False">False</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <input type="submit" name="submit" value="Add Criteria" class="btn btn-success" id="">
                                <a class="btn btn-primary" href="viewCriteria.php">Cancel</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

</div>



<?php
include('includes/footer.php');
include('includes/scripts.php');
?>