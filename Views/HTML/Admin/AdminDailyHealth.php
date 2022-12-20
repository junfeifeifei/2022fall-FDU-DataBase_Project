<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>查看健康打卡</title>
</head>
<body>
<form method="post">
    <div>请输入学生的id<input type="text" name = "dailyhealth-student_id"></div>
    <div>请输入查询天数：<input type="text" name = "dailyhealth-count"></div>
    <button type="submit">查询</button>
</form>
<?php
$student_id = "";
$count = "";
if(isset($_POST["dailyhealth-student_id"])&&isset($_POST["dailyhealth-count"])){
    $student_id = $_POST["dailyhealth-student_id"];
    $count = $_POST["dailyhealth-count"];
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    $getDailyHealth = "select * from daily_health where student_id = '$student_id'";
    $studentDailyHealth = $mysqli->query($getDailyHealth);
    $rownum = mysqli_num_rows($studentDailyHealth);
    if($rownum == 0){
        $studentDailyHealth->free();
        $mysqli->close();
        echo "<script>alert('不存在这个学生！')</script>";
    }
    //如果有这个学生
    else{
        $allDate = array();
        //一个数组，存了这个学生所有打卡记录的日期
        for($i = 0;$i<$rownum;$i++){
            $rows=mysqli_fetch_assoc($studentDailyHealth);
            $date = $rows["record_date"];
            array_push($allDate,$date);
        }
        $len = count($allDate);
        date_default_timezone_set('PRC');
        //过去n天的记录，对每一天进行筛选
        $validDate = array();
        $targetDate = array();
        for($i = 0;$i < $count;$i++){
            //获得过去某天的年月日
            $date = date("Y-m-d",strtotime("-$i days"));
            array_push($targetDate,$date);
        }
        for($i = 0;$i < $len;$i++){
            $temp = $allDate[$i];
            for($j = 0;$j < $count;$j++){
                $pos = strpos($temp,$targetDate[$j]);
                if($pos !== false){
                    array_push($validDate,$temp);
                }
            }
        }
        //validDate代表的是有效的数据，也就是天数在想要的天数内的数据
        $dateLen = count($validDate);
        for($i = 0;$i<$dateLen;$i++){
            $getStudentDailyHealth = "select * from daily_health where student_id = '$student_id' and record_date = '$validDate[$i]'";
            $dailyHealth = $mysqli->query($getStudentDailyHealth);
            $rownum = mysqli_num_rows($dailyHealth);
            for($j = 0;$j < $rownum;$j++){
                $rows = mysqli_fetch_assoc($dailyHealth);
                $student_id = $rows["student_id"];
                if($rows["health_state"] == 1){
                    $state = "良好";
                }
                else{
                    $state = "不好";
                }
                $record_date = $rows["record_date"];
                $record_location = $rows["record_location"];
                $temperature = $rows["temperature"];
                echo "<div>student_id:$student_id;健康状况：$state;打卡日期：$record_date;打卡地点：$record_location;温度：$temperature</div>";
            }
        }
    }
}


?>
</body>
</html>