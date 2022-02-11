<?php

include('config/database.php');

// Delete Courses

if (isset($_POST['deleteCourse'])) {

    $user_id = $_POST['deleteCourse'];

    $sql = "delete from course where c_id='$user_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['message'] = 'Deleted Successfully';
    } else {
        $_SESSION['message'] = 'Deletion is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewCourse.php");
    die;
}


// Delete CoursesTaken

if (isset($_POST['deleteCourseTaken'])) {

    $user_id = $_POST['deleteCourseTaken'];

    $sql = "delete from coursetaken where id='$user_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['message'] = 'Deleted Successfully';
    } else {
        $_SESSION['message'] = 'Deletion is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewCourseTaken.php");
    die;
}

// Delete Department

if (isset($_POST['deleteDepartment'])) {

    $user_id = $_POST['deleteDepartment'];

    $sql = "delete from department where d_id='$user_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['message'] = 'Deleted Successfully';
    } else {
        $_SESSION['message'] = 'Deletion is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewDepartment.php");
    die;
}


// Delete Faculty

if (isset($_POST['deleteFaculty'])) {

    $user_id = $_POST['deleteFaculty'];

    $sql = "delete from faculty where f_id='$user_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['message'] = 'Deleted Successfully';
    } else {
        $_SESSION['message'] = 'Deletion is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewFaculty.php");
    die;
}

// Delete Semester

if (isset($_POST['deleteSemester'])) {

    $user_id = $_POST['deleteSemester'];

    $sql = "delete from semester where s_id='$user_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['message'] = 'Deleted Successfully';
    } else {
        $_SESSION['message'] = 'Deletion is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewSemester.php");
    die;
}

// Delete Question

if (isset($_POST['deleteQuestion'])) {

    $user_id = $_POST['deleteQuestion'];

    $sql = "delete from question where q_id='$user_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['message'] = 'Deleted Successfully';
    } else {
        $_SESSION['message'] = 'Deletion is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewQuestion.php");
    die;
}

// Delete Criteria

if (isset($_POST['deleteCriteria'])) {

    $user_id = $_POST['deleteCriteria'];

    $sql = "delete from criteria where cr_id='$user_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['message'] = 'Deleted Successfully';
    } else {
        $_SESSION['message'] = 'Deletion is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewCriteria.php");
    die;
}


// Delete Department Taken

if (isset($_POST['deleteDepartmentTaken'])) {

    $user_id = $_POST['deleteDepartmentTaken'];

    $sql = "delete from departmenttaken where dt_id='$user_id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['message'] = 'Deleted Successfully';
    } else {
        $_SESSION['message'] = 'Deletion is not Successfull';
        echo "<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);

    header("Location: viewDepartmentTaken.php");
    die;
}
