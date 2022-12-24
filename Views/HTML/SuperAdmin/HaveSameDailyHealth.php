<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div>查询连续n天健康打卡相同的学生id</div>
<form method="post">
    <div>请输入查询天数：<input type="text" name = "havesamedailyhealth-count"></div>
    <button type="submit">查询</button>
</form>
<?php
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
for($i = 0;$i<$studentLength;$i++){
    $studentId = $studentArray[$i];
    $sql = "select max(record_date) as max from daily_health where student_id = '$studentId'";
    $sqlQuery = $mysqli->query($sql);
    $rownum = mysqli_num_rows($sqlQuery);
    for($j=0;$j<$rownum;$j++){
        $rows = mysqli_fetch_assoc($sqlQuery);
        //最新一次记录的日期
        $dateMax = $rows['max'];
        $arr = explode(" ",$dateMax);
        //精确到分钟的时间
        $sameDate = $arr[0];
        $sameTime = $arr[1];
    }
    $nums = 0;
    for($k = 0;$k<$count;$k++){
        //过去n天的日期
        $date = date("Y-m-d",strtotime("-$k days",strtotime($sameDate)) );
        $date2 = $date." ".$sameTime;
        $sql2 = "select * from daily_health where record_date = '$date2' and student_id = '$studentId'";
        $sqlQuery2 = $mysqli->query($sql2);
        $rownum2 = mysqli_num_rows($sqlQuery2);
        if($rownum2 != 0){
            $nums++;
        }
        else break;
    }
    if($nums == $count){
        echo "<div>$studentId</div>";
    }
}
?>
</body>
</html>