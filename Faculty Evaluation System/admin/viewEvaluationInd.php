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
        <li class="breadcrumb-item">Evaluation Result</li>
    </ol>
    <div class="row">
        <!-- Show Message-->
        <?php include('message.php'); ?>

        <?php
        $select_f = "SELECT f_id,f_name from faculty";
        $select_f_result = mysqli_query($connection, $select_f);

        if (isset($_POST['f_name'])) {
            $Curr_Faculty = $_POST['f_name'];

            $current_f = "SELECT f_name from faculty where f_id = '$Curr_Faculty'";
            $current_f_result = mysqli_query($connection, $current_f);
            $current_f_result = mysqli_fetch_assoc($current_f_result);
        } else {
            $Curr_Faculty = 'Choose Faculty';
        }


        // $Curr_Faculty = $_POST['f_name'];




        ?>


        <form action="viewEvaluationInd.php" method="post">
            <div class="col-md-12">
                <div class="input-group col-md-12 mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Faculty</label>
                    <select name="f_name" class="form-select" id="inputGroupSelect01" required>
                        <option value=""><?= isset($current_f_result) ? $current_f_result['f_name'] . ' (Current)' : $Curr_Faculty ?></option>
                        <?php
                        foreach ($select_f_result as $faculty) {
                        ?>
                            <option value="<?= $faculty['f_id'] ?>"><?= $faculty['f_name'] ?></option>
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

            $Curr_Faculty = $_POST['f_name'];

            $sql_f = "select c_id,c_name,section,f_name, d_name, s_name 
            from 
            course,department,semester,faculty
            where 
            course.faculty_f_id=faculty.f_id and course.department_d_id = department.d_id and course.semester_s_id = semester.s_id and faculty.f_id = '$Curr_Faculty'
            ";

            $result_f = mysqli_query($connection, $sql_f);


        ?>

            <div class="col-md-12 mt-5 mb-5">
                <p style="text-align: justify;" class="fs-5 bg-light p-3">There are a lot of Faculties in different Department in this University. This Table shows their Courses of different Semester and their Advising ratings of respective course according to the Department.</p>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Individual Faculty Evaluation
                            <!-- <a class="btn btn-primary float-end" href="addCourse.php">Add Courses</a> -->
                        </h4>

                    </div>
                    <div class="card-body" style="overflow-x:auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Faculty</th>
                                    <th>Department</th>
                                    <th>Course Name</th>
                                    <th>Section</th>
                                    <th>Semester</th>
                                    <th>Evaluation Rating (50)</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $curr_ind = 0;
                                if (mysqli_num_rows($result_f) > 0) {

                                    foreach ($result_f as $idx => $row) {
                                ?>
                                        <tr>
                                            <td><?= $idx + 1; ?></td>
                                            <td><?= $row['f_name']; ?></td>
                                            <td><?= $row['d_name']; ?></td>
                                            <td><?= $row['c_name']; ?></td>
                                            <td><?= $row['section']; ?></td>
                                            <td><?= $row['s_name']; ?></td>

                                            <?php
                                            $Co_c_id = $row["c_id"];

                                            $sql = "SELECT course.c_name,course.section,department.d_name,semester.s_name,faculty.f_name,course_c_id, SUM(rating) as ev_rating 
                                           FROM evaluation,course,faculty,department,semester 
                                           where evaluation.course_c_id = course.c_id and course.semester_s_id = semester.s_id and course.department_d_id = department.d_id and course.faculty_f_id = faculty.f_id and faculty.f_id = '$Curr_Faculty' and course.c_id = '$Co_c_id' GROUP BY course_c_id";

                                            $result = mysqli_query($connection, $sql);

                                            if (mysqli_num_rows($result) > 0) {
                                                $result = mysqli_fetch_array($result);
                                                echo "<td>" . $result['ev_rating'] . "</td>";

                                            ?>
                                        </tr>

                            <?php
                                            } else {
                                                echo "<td>Not Evaluated</td>";
                                            }
                                        }
                                    }

                            ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <p style="text-align: justify;" class="fs-5 bg-light p-3">There are a lot of Faculties in different Department in this University. This Bar Chart shows their total Advising ratings of respective course in a Semester according to the Department.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 mt-5">
                    <div class="card mb-4">

                        <div class="card-body">
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                        </div>
                        <div class="card-footer text-center">
                            <p>Faculty Wise Evaluation Rating</p>
                        </div>
                    </div>
                </div>
            </div>

        <?php

        }

        ?>





    </div>

</div>

<!-- Bar Chart Department wise student-->

<?php


$fac_sql = "SELECT semester_s_id,s_name,SUM(tot_rating) AS rating FROM (SELECT semester_s_id,semester.s_name,SUM(rating) AS tot_rating
FROM evaluation,course,faculty,department,semester 
where evaluation.course_c_id = course.c_id and course.semester_s_id = semester.s_id and course.department_d_id = department.d_id and course.faculty_f_id = faculty.f_id and faculty.f_id = '$Curr_Faculty' GROUP by course_c_id) temp GROUP BY semester_s_id";

$fac_result = mysqli_query($connection, $fac_sql);
// $fac_result = mysqli_fetch_assoc($fac_result);

$fac_name_arr = array();
$fac_rating_arr = array();

foreach ($fac_result as $key => $value) {
    array_push($fac_name_arr, $value['s_name']);
    array_push($fac_rating_arr, $value['rating']);
}


?>

<!-- bar chart start-->
<script>
    const BarLabels = <?php echo json_encode($fac_name_arr) ?>;

    const BarData = {
        labels: BarLabels,
        datasets: [{
            label: 'Faculty',
            data: <?php echo json_encode($fac_rating_arr) ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 1
        }]
    };

    const BarConfig = {
        type: 'bar',
        data: BarData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };
</script>

<script>
    const myBarChart = new Chart(
        document.getElementById('myBarChart'),
        BarConfig
    );
</script>

<!-- bar chart end-->

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>