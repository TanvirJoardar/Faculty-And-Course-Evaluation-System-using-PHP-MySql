<?php
ob_start();                                     // for header() error
include('config/database.php');
include('includes/header.php');
include('includes/admin-function.php');
$User_data = check_login($connection);
ob_end_flush();                                 // for header() error
?>

<!-- Pie Chart Advising -->

<?php

$adv_sql = "SELECT COUNT(coursetaken.id) as Adv_done FROM coursetaken where adv_status = 'True'";
$adv_result = mysqli_query($connection, $adv_sql);

$adv_tot = "SELECT COUNT(coursetaken.id) as Tot_adv FROM coursetaken";
$Tot_adv_result = mysqli_query($connection, $adv_tot);

if (mysqli_num_rows($adv_result) > 0  && mysqli_num_rows($Tot_adv_result) > 0) {
    $adv_result = mysqli_fetch_assoc($adv_result);
    $Tot_adv_result = mysqli_fetch_assoc($Tot_adv_result);
}

$done =  (int)$adv_result['Adv_done'] / (int)$Tot_adv_result['Tot_adv'];
$done *= 100;
$not_done = 100 - $done;


$adv_arr = array($done, $not_done);


?>

<!-- Bar Chart Department wise student-->

<?php

$dep_sql = "SELECT department.d_name,COUNT(departmenttaken.dt_id) as num  FROM departmenttaken,department WHERE departmenttaken.department_d_id = department.d_id GROUP BY departmenttaken.department_d_id;";
$dep_result = mysqli_query($connection, $dep_sql);

$dep_name_arr = array();
$count_arr = array();

foreach ($dep_result as $key => $value) {
    array_push($dep_name_arr, $value['d_name']);
    array_push($count_arr, $value['num']);
}


?>


<div class="container-fluid px-4">
    <h1 class="mt-4">EWU Faculty & Course Evaluation</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>


    <?php include('message.php'); ?>
    <div class="row">

        <div class="col-xl-12">
            <div class="card mb-4">
                <?php
                $curr_user_email = $_SESSION['USER_DATA']['EMAIL'];

                $page_sql = "SELECT page FROM pages where email= '$curr_user_email' Order by number DESC LIMIT 5";
                $page_result = mysqli_query($connection, $page_sql);

                ?>

                <div class="card-body fs-4">Most Visited Pages</div>
                <div class="card-footer align-items-center justify-content-between">
                    <?php
                    foreach ($page_result as $key => $page) {
                    ?>
                        <div><span><?= $key + 1 . ". " ?></span><a class="small link-primary mb-3" href="<?= $page['page'] ?>"><?= $page['page'] ?></a></div>
                    <?php
                    }
                    ?>

                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Student
                    <?php
                    $select_s = "select count('id') from user";
                    $select_s_result = mysqli_query($connection, $select_s);

                    if (mysqli_num_rows($select_s_result) > 0) {
                        $S_Count = mysqli_fetch_assoc($select_s_result);
                        echo '<h4 class="mb-0">' . $S_Count["count('id')"] . '</h4>';
                    } else {
                        echo 'No Data';
                    }
                    ?>

                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="viewStudent.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Toatal Faculty
                    <?php
                    $select_s = "select count('f_id') from faculty";
                    $select_s_result = mysqli_query($connection, $select_s);

                    if (mysqli_num_rows($select_s_result) > 0) {
                        $S_Count = mysqli_fetch_assoc($select_s_result);
                        echo '<h4 class="mb-0">' . $S_Count["count('f_id')"] . '</h4>';
                    } else {
                        echo 'No Data';
                    }
                    ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="viewFaculty.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Total Department
                    <?php
                    $select_d = "select count('d_id') from department";
                    $select_d_result = mysqli_query($connection, $select_d);

                    if (mysqli_num_rows($select_d_result) > 0) {
                        $D_Count = mysqli_fetch_assoc($select_d_result);
                        echo '<h4 class="mb-0">' . $D_Count["count('d_id')"] . '</h4>';
                    } else {
                        echo 'No Data';
                    }
                    ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="viewDepartment.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Total Courses
                    <?php
                    $select_cr = "select count('c_id') from course";
                    $select_cr_result = mysqli_query($connection, $select_cr);

                    if (mysqli_num_rows($select_cr_result) > 0) {
                        $CR_Count = mysqli_fetch_assoc($select_cr_result);
                        echo '<h4 class="mb-0">' . $CR_Count["count('c_id')"] . '</h4>';
                    } else {
                        echo 'No Data';
                    }
                    ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="viewCourse.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-5">
            <p style="text-align: justify;" class="fs-5">A considerable body of research connects students' University experiences to their interactions with a faculty member. Quality academic advising is key to student success and the faculty advisor is a valuable piece of the advisor-student interaction. To ensure student success through academic advising, it is important for institutions to understand how they can best support faculty in their advisor roles.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <div class="card mb-4">

                    <div class="card-body"><canvas id="myChart" width="100%" height="50"></canvas></div>

                    <div class="card-footer text-center">
                        <p>Advising Status</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-5">
            <p style="text-align: justify;" class="fs-5">There are a number of different Department in this University. This Bar Chart shows the number of students according to the Department</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="card mb-4">

                    <div class="card-body">
                        <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                    </div>
                    <div class="card-footer text-center">
                        <p>Department Wise Student</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- Script -->


<!-- pie chart start-->

<script>
    const data = {
        labels: [
            ' Advising Done',
            ' Not Done'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: <?php echo json_encode($adv_arr) ?>,
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
    };
</script>

<script>
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>

<!-- pie chart end-->


<!-- bar chart start-->
<script>
    const BarLabels = <?php echo json_encode($dep_name_arr) ?>;

    const BarData = {
        labels: BarLabels,
        datasets: [{
            label: 'Department wise Student',
            data: <?php echo json_encode($count_arr) ?>,
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