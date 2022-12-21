<?php
function dailyhealthapply(){
    session_start();
    //获取post表单
    $currentDate = $_POST["currentDate"];
    $student_id = $_POST["student_id"];
    $health_state = $_POST["health_state"];
    $record_location = $_POST["record_location"];
    $temperature = $_POST["temperature"];
    //连接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $applydailyhealth="insert into daily_health (student_id,record_date,health_state,record_location,temperature) values('$student_id','$currentDate','$health_state','$record_location','$temperature')";
    if(!$mysqli->query($applydailyhealth)){
        echo"<script>alert('健康状况打卡失败！请重新填报！');history.back();</script>";
    }
    else {
        echo"<script>alert('打卡成功！');window.location.href='/student';</script>";
    }
    $mysqli->close();
}

function last7day(){
    //连接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    for($i=1;$i<8;$i++){
        echo "day".$i.":";
        $index="m".$i;
        $id=$_GET[$index];
        if($id==0){
            echo "当天无健康打卡！<br>";
            continue;
        }
        $selectdaily="select * from daily_health where daily_health_id = ".$id;
        $row=$mysqli->query($selectdaily)->fetch_assoc();
        echo "打卡时间：";
        echo $row["record_date"];
        echo " 打卡地点：";
        echo $row["record_location"];
        echo " 体温：";
        echo $row["temperature"];
        echo "°C 健康状态：";
        if($row["health_state"]==1) echo "正常";
        if($row["health_state"]==2) echo "阳性";
        if($row["health_state"]==3) echo "发烧";
        echo "<br>";
    }
    $mysqli->close();
}

