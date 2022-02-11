<?php

include('../config/database.php');



echo '<h1>Evaluation Result Page</h1>';


$sql = 'select question.question,rating from evaluation,course,faculty,user,question where course_c_id =c_id and faculty_f_id = f_id and user_u_id = user.id and question_q_id = q_id and criteria = 1 and user.id = 1';
$result = mysqli_query($connection, $sql);

$arr = mysqli_fetch_assoc($result);

print_r($arr);
