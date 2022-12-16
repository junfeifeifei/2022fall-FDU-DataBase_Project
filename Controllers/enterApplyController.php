<?php
function enterApply(){
    session_start();
    //获取post表单
    $student_id = $_POST["student_id"];
    $reason = $_POST["reason"];
    $return_date = $_POST["return_date"];
    $return_date_array=explode('T',$return_date);
    $return_date_array[1]=$return_date_array[1].":00";
    $return_date_array[0]=$return_date_array[0]." ";
    $return_date=$return_date_array[0].$return_date_array[1];
    $counselor_id = $_POST["counselor_id"];
    $manager_id = $_POST["manager_id"];
    $daily_health_id_1 = $_POST["daily_health_id_1"];
    $daily_health_id_2 = $_POST["daily_health_id_2"];
    $daily_health_id_3 = $_POST["daily_health_id_3"];
    $daily_health_id_4 = $_POST["daily_health_id_4"];
    $daily_health_id_5 = $_POST["daily_health_id_5"];
    $daily_health_id_6 = $_POST["daily_health_id_6"];
    $daily_health_id_7 = $_POST["daily_health_id_7"];
    $apply_date = $_POST['apply_date'];
    $currentState = 1;
    //连接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $applyenter="insert into admission_application (student_id,reason,return_date,counselor_id,manager_id,daily_health_id_1,daily_health_id_2,daily_health_id_3,daily_health_id_4,daily_health_id_5,daily_health_id_6,daily_health_id_7,apply_date,currentState) values ('$student_id','$reason','$return_date','$counselor_id','$manager_id',$daily_health_id_1,$daily_health_id_2,$daily_health_id_3,$daily_health_id_4,$daily_health_id_5,$daily_health_id_6,$daily_health_id_7,'$apply_date','$currentState')";
    if(!$mysqli->query($applyenter)){
        echo"<script>alert('申请失败！请重新填报！');history.back();</script>";
    }
    else {
        echo"<script>alert('申请成功！');window.location.href='/student';</script>";
    }
    $mysqli->close();
}



