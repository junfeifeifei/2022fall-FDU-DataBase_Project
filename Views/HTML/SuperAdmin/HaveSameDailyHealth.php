<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
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
<div>查询连续n天健康打卡相同的学生id</div>
<form method="post">
    <div>请输入查询天数：<input type="text" name = "havesamedailyhealth-count"></div>
    <button type="submit">查询</button>
</form>
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
$count = "";
if(isset($_POST["havesamedailyhealth-count"])){
    $count = $_POST["havesamedailyhealth-count"];
}
$mysqli = mysqli_connect("localhost","root","1234","admission");
$getAllStudent = "select distinct student_id from daily_health";
$allStudent = $mysqli->query($getAllStudent);
$rownum = mysqli_num_rows($allStudent);
$studentArray = array();
for($i = 0;$i<$rownum;$i++){
    $rows = mysqli_fetch_assoc($allStudent);
    $student_id = $rows["student_id"];
    array_push($studentArray,$student_id);
}
$studentLength = count($studentArray);
echo "<div>连续$count 天健康打卡时间一样的学生的id如下：</div>";
for($i = 0;$i<$studentLength;$i++) {
    $studentId = $studentArray[$i];
    $sql = "select max(record_date) as max from daily_health where student_id = '$studentId'";
    $sqlQuery = $mysqli->query($sql);
    $rownum = mysqli_num_rows($sqlQuery);
    for ($j = 0; $j < $rownum; $j++) {
        $rows = mysqli_fetch_assoc($sqlQuery);
        //最新一次记录的日期
        $dateMax = $rows['max'];
        $arr = explode(" ", $dateMax);
        //精确到分钟的时间
        $sameDate = $arr[0];
        $sameTime = $arr[1];
    }
    $nums = 0;
    for ($k = 0; $k < $count; $k++) {
        //过去n天的日期
        $date = date("Y-m-d", strtotime("-$k days", strtotime($sameDate)));
        $date2 = $date . " " . $sameTime;
        $sql2 = "select * from daily_health where record_date = '$date2' and student_id = '$studentId'";
        $sqlQuery2 = $mysqli->query($sql2);
        $rownum2 = mysqli_num_rows($sqlQuery2);
        if ($rownum2 != 0) {
            $nums++;
        } else break;
    }
    if ($nums == $count) {
        $findStudent = "select * from student where student_id = '$studentId'";
        $getStudent = $mysqli->query($findStudent);
        $num4 = mysqli_num_rows($getStudent);
        for ($m = 0; $m < $num4; $m++) {
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
            $cou ++;
        }
    }
}
echo "共$cou 个学生";
?>
</table>
</body>
</html>