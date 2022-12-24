<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form method="post">
    <div>请输入查询天数：<input type="text" name = "departmostenter-count"></div>
    <button type="submit">查询</button>
</form>
<?php
$count = "";
if(isset($_POST["departmostenter-count"])){
    $count = $_POST["departmostenter-count"];
}
$mysqli = mysqli_connect("localhost","root","1234","admission");
$getAllDepart = "select distinct department_name from student";
$allDepart = $mysqli->query($getAllDepart);
$departnum = mysqli_num_rows($allDepart);
$departArray = array();
for($i=0;$i<$departnum;$i++){
    $rows = mysqli_fetch_assoc($allDepart);
    $department_name = $rows['department_name'];
    array_push($departArray,$department_name);
}
$targetDate = array();
for($i = 0;$i < $count;$i++){
    //获得过去某天的年月日
    $date = date("Y-m-d",strtotime("-$i days"));
    array_push($targetDate,$date);
}
$targetDateLength = count($targetDate);
//对每个院系进行循环
for($i=0;$i<$departnum;$i++){
    //当前的院系名称
    $depart_name = $departArray[$i];
    $handan = 0;
    $jiangwan = 0;
    $zhangjiang = 0;
    $fenglin = 0;
//    $sql = "select log.log_enter_campus_name,COUNT(log.log_enter_campus_name) as count from student,log
//    where student.student_id = log.student_id and student.department_name ='$depart_name'  group by log.log_enter_campus_name ORDER BY count DESC";
    $sql = "select * from log,student where log.student_id=student.student_id and student.department_name = '$depart_name'";
    $sqlQuery = $mysqli->query($sql);
    $rownum = mysqli_num_rows($sqlQuery);
    //对于每条数据
    for($j = 0;$j<$rownum;$j++){
        $rows = mysqli_fetch_assoc($sqlQuery);
        $enter_time = $rows['log_enter_time'];
        $campus_name = $rows['log_enter_campus_name'];
        for($k = 0;$k<$targetDateLength;$k++){
            $date = $targetDate[$k];
            $pos = strpos($enter_time,$date);
            if($pos !== false){
                if($campus_name == "邯郸校区") $handan++;
                else if($campus_name == "张江校区") $zhangjiang++;
                else if($campus_name == "江湾校区") $jiangwan++;
                else $fenglin++;
            }
        }
    }

    echo "<div>$depart_name </div>
          <div>邯郸共$handan 条;张江共$zhangjiang 条;江湾共$jiangwan 条;枫林共$fenglin 条;</div>";
}
?>
</body>
</html>