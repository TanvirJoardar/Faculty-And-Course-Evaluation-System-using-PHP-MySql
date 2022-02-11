<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
?>


<?php

// Variable
$F_Name = $F_NameErr = "";

if ($F_NameErr == "") {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        // Name validation
        if (empty($_POST['f_name'])) {
            $F_NameErr = "Faculty Name is required";
        } else {
            $F_Name = test_input($_POST["f_name"]);

            $sql = "select f_name from faculty where f_name = '$F_Name'";
            $result = mysqli_query($connection, $sql);

            if ($result && mysqli_num_rows($result) > 0) {

                $db_f_name = mysqli_fetch_assoc($result);
                if ($db_f_name['f_name'] == $F_Name) {
                    $F_NameErr = "This Faculty is Already Exists";
                }
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

if (isset($_POST['submit'])) {

    $D_id = $_POST['d_id'];

    // Performing insert query execution
    $user_id = $_GET['id'];
    $sql = "INSERT INTO faculty (f_id, f_name, department_d_id) VALUES ('','$F_Name','$D_id' )";

    if (mysqli_query($connection, $sql)) {
        $_SESSION['message'] = 'Add Faculty Successfully';
    } else {
        $_SESSION['message'] = 'Add Faculty is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewFaculty.php");
    ob_end_flush();                       // for header() error
    die;
}



?>

<?php
$select_d = "select d_id, d_name from department";
$select_d_result = mysqli_query($connection, $select_d);
?>


<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Faculty</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Faculty</h4>

                </div>
                <div class="card-body">

                    <!--  need to change action-->
                    <form action="AddFaculty.php" method="post">
                        <div class="row">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="">Faculty Name</label>
                                    <input type="text" name="f_name" class="form-control" id="">
                                    <?php if ($F_NameErr != "") {
                                        echo '<span style="color: red">' . '* ' . $F_NameErr . '</span><br>';
                                    } ?>
                                </div>
                                <div class="input-group col-md-12 mb-3">
                                    <label class="input-group-text" for="inputGroupSelect01">Department</label>
                                    <select name="d_id" class="form-select" id="inputGroupSelect01" required>
                                        <?php

                                        if (mysqli_num_rows($select_d_result) > 0) {

                                            foreach ($select_d_result as $department) {
                                        ?>
                                                <option value="<?= $department['d_id'] ?>"><?= $department['d_name'] ?></option>
                                        <?php
                                            }
                                        } else {
                                            echo "<option value=''>No department</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <input type="submit" name="submit" value="Add Faculty " class="btn btn-success" id="">
                                    <a class="btn btn-primary" href="viewFaculty.php">Cancel</a>
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