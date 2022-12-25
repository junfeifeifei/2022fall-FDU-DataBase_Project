<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>已申请但未离校</title>
</head>
<body>
<div>已提交离校申请但是尚未离校的学生id如下：</div>
<?php
$mysqli = mysqli_connect("localhost","root","1234","admission");
$getAllApplyStudent = "select distinct student_id from log";
$allApplyStudent = $mysqli->query($getAllApplyStudent);
$rownum=mysqli_num_rows($allApplyStudent);
$allApplyId = array();
for($i=0;$i<$rownum;$i++){
    $rows=mysqli_fetch_assoc($allApplyStudent);
    $student_id = $rows['student_id'];
    array_push($allApplyId,$student_id);
}
$length = count($allApplyId);
$abc = array();
for($i = 0;$i<$length;$i++){
    $getStudentApply = "select max(log_enter_time) as max from log where student_id = '$allApplyId[$i]' ";
    $getMaxEnter = $mysqli->query($getStudentApply);
    $num = mysqli_num_rows($getMaxEnter);
    for($j=0;$j<$num;$j++){
        $rows = mysqli_fetch_assoc($getMaxEnter);
        $maxEnter = $rows['max'];
    }
    $getDepartApply = "select * from depart_application where student_id = '$allApplyId[$i]'";
    $departApply = $mysqli->query($getDepartApply);
    $num2 = mysqli_num_rows($departApply);
    $getStudentLog = "select * from log where  log_enter_time='$maxEnter' and student_id = '$allApplyId[$i]'";
    $studentLog = $mysqli->query($getStudentLog);
    $num3 = mysqli_num_rows($studentLog);
    for($k=0;$k<$num3;$k++){
        $rows = mysqli_fetch_assoc($studentLog);
        $a = $rows['time'];
    }
    if(is_null($a) && $num2 >= 1){
        echo "<div>$allApplyId[$i]</div>";
    }
}

?>
</body>
</html>