<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
?>

<!-- Form validation -->

<?php


// Variable
$Dep_Name = $Dep_NameErr = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Name validation
    if (empty($_POST['d_name'])) {
        $Dep_NameErr = "Department Name is required";
    } else {
        $Dep_Name = test_input($_POST["d_name"]);

        $sql = "select d_name from department where d_name = '$Dep_Name'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $db_d_name = mysqli_fetch_assoc($result);
            if ($db_d_name['d_name'] == $Dep_Name) {
                $Dep_NameErr = "This Department is Already Exists";
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

if ($Dep_NameErr == "") {

    if (isset($_POST['submit'])) {

        // Performing insert query execution
        $user_id = $_GET['id'];
        $sql = "UPDATE department SET d_name = '$Dep_Name' WHERE d_id='$user_id'";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Update Department info Successfully';
        } else {
            $_SESSION['message'] = 'Update Admin info is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: viewDepartment.php");
        ob_end_flush();                       // for header() error
        die;
    }
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Department</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Department info</h4>

                </div>
                <div class="card-body">

                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $sql = "select * from department where d_id='$user_id'";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            foreach ($result as $row) {

                    ?>
                                <form action="editDepartment.php?id=<?= $user_id; ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="">Department Name</label>
                                            <input type="text" name="d_name" value="<?= $row['d_name']; ?>" class="form-control" id="">
                                            <?php if ($Dep_NameErr != "") {
                                                echo '<span style="color: red">' . '* ' . $Dep_NameErr . '</span><br>';
                                            } ?>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <input type="submit" name="submit" value="Update Department" class="btn btn-success" id="">
                                            <a class="btn btn-primary" href="viewDepartment.php">Cancel</a>
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