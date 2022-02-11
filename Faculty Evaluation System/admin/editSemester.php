<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
?>


<?php

// Variable
$S_Name = $S_NameErr = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Name validation
    if (empty($_POST['s_name'])) {
        $S_NameErr = "Semester Name is required";
    } else {
        $S_Name = test_input($_POST["s_name"]);

        $user_id = $_GET['id'];
        $sql = "select s_name from semester where s_name = '$S_Name' and s_id != '$user_id'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $db_s_name = mysqli_fetch_assoc($result);
            if ($db_s_name['s_name'] == $S_Name) {
                $S_NameErr = "This Semester is Already Exists";
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

if ($S_NameErr == "") {

    if (isset($_POST['submit'])) {

        $S_Running = $_POST['sem_running'];
        // Performing insert query execution
        $user_id = $_GET['id'];

        if ($S_Running == 'True') {
            $S_Running_excp = 'False';
            $sql_excp = "UPDATE semester SET s_running = '$S_Running_excp' WHERE s_id !='$user_id'";

            if (mysqli_query($connection, $sql_excp)) {
                $_SESSION['message'] = 'Update Semester Exception Successfully';
            } else {
                $_SESSION['message'] = 'Update Semester Exception is not Successfull';
                echo "<br>" . mysqli_error($connection);
            }
        }

        $sql = "UPDATE semester SET s_name = '$S_Name',s_running = '$S_Running' WHERE s_id='$user_id'";

        if (mysqli_query($connection, $sql)) {
            $_SESSION['message'] = 'Update Semester Successfully';
        } else {
            $_SESSION['message'] = 'Update Semester is not Successfull';
            echo "<br>" . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);

        header("Location: viewSemester.php");
        ob_end_flush();                       // for header() error
        die;
    }
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Semester</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Semester</h4>

                </div>
                <div class="card-body">

                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $sql = "select semester.s_name,semester.s_running
                            from 
                            semester
                            where 
                            semester.s_id='$user_id'";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            foreach ($result as $row) {

                    ?>
                                <!--  need to change action-->
                                <form action="editSemester.php?id=<?= $user_id; ?>" method="post">
                                    <div class="row">

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="">Semester Name</label>
                                                <input type="text" name="s_name" value="<?= $row['s_name']; ?>" class="form-control" id="">
                                                <?php if ($S_NameErr != "") {
                                                    echo '<span style="color: red">' . '* ' . $S_NameErr . '</span><br>';
                                                } ?>
                                            </div>
                                            <div class="input-group col-md-12 mb-3">
                                                <label class="input-group-text" for="inputGroupSelect01">Semester Running</label>
                                                <select name="sem_running" class="form-select" id="inputGroupSelect01" required>
                                                    <option value=""><?= $row['s_running']; ?> (current)</option>
                                                    <option value="True">True</option>
                                                    <option value="False">False</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <input type="submit" name="submit" value="Update Semester " class="btn btn-success" id="">
                                                <a class="btn btn-primary" href="viewSemester.php">Cancel</a>
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