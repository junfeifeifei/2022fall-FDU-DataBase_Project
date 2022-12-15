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



