<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>已申请但未离校</title>
</head>

<style>
    table {
        border-right: 1px solid #000000;
        border-bottom: 1px solid #000000;
        text-align: center;
        margin:auto;
    }

    table tr {
        border-left: 1px solid #000000;
        border-top: 1px solid #000000;
    }

    table td {
        border-left: 1px solid #000000;
        border-top: 1px solid #000000;
    }
</style>
<body>
<div>未提交申请但是离校超过24h的学生信息如下：</div>
<table style="border: 1px solid">
    <tr>
        <td>student_id</td>
        <td>name</td>
        <td>phone_number</td>
        <td>email</td>
        <td>dormitory</td>
        <td>living_address</td>
        <td>idcard_type</td>
        <td>idnumber</td>
        <td>belong_campus_name</td>
        <td>class_name</td>
        <td>department_name</td>
    </tr>
<?php
$cou = 0;
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
    //最新一条离校记录
    for($k=0;$k<$num3;$k++){
        $rows = mysqli_fetch_assoc($studentLog);
        $a = $rows['log_leave_time'];
    }
    $leaveDate = strtotime($a);
    $nowDate = strtotime(date('Y-m-d H:i:s'));
    $diff = abs($nowDate - $leaveDate);
    if(!is_null($a)&&$diff>3600*24 && $num2 == 0){
//        echo "<div>$allApplyId[$i]</div>";
        $findStudent = "select * from student where student_id = '$allApplyId[$i]'";
        $getStudent = $mysqli->query($findStudent);
        $num4 = mysqli_num_rows($getStudent);
        for($m = 0 ;$m<$num4;$m++){
            $rowss = mysqli_fetch_assoc($getStudent);
            $id = $rowss['student_id'];
            $name = $rowss['name'];
            $phone_number = $rowss['phone_number'];
            $dormitory = $rowss['dormitory'];
            $email = $rowss['email'];
            $living_address = $rowss['living_address'];
            $idcard_type = $rowss['idcard_type'];
            $idnumber = $rowss['idnumber'];
            $belong_campus_name = $rowss['belong_campus_name'];
            $class_name = $rowss['class_name'];
            $department_name = $rowss['department_name'];
            echo
            "<div>
            <tr>
                <td>$id</td>
                <td>$name</td>
                <td>$phone_number</td>
                <td>$email</td>
                <td>$dormitory</td>
                <td>$living_address</td>
                <td>$idcard_type</td>
                <td>$idnumber</td>
                <td>$belong_campus_name</td>
                <td>$class_name</td>
                <td>$department_name</td>
            </tr>
        </div>";
            $cou++;
        }
    }
}
echo "共$cou 个学生";
?>
</table>
</body>
</html>