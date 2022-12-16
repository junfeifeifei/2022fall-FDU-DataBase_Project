<?php
function leaveApply(){
    session_start();
    //获取post表单
    $student_id = $_POST["student_id"];
    $reason = $_POST["reason"];
    $destination = $_POST["destination"];

    $departure_date = $_POST["departure_date"];
    $departure_date_array=explode('T',$departure_date);
    $departure_date_array[1]=$departure_date_array[1].":00";
    $departure_date_array[0]=$departure_date_array[0]." ";
    $departure_date=$departure_date_array[0].$departure_date_array[1];


    $return_date = $_POST["return_date"];
    $return_date_array=explode('T',$return_date);
    $return_date_array[1]=$return_date_array[1].":00";
    $return_date_array[0]=$return_date_array[0]." ";
    $return_date=$return_date_array[0].$return_date_array[1];

    $counselor_id = $_POST["counselor_id"];
    $manager_id = $_POST["manager_id"];
    $apply_date = $_POST['apply_date'];
    $currentState = 1;
    //连接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $applyenter="insert into depart_application (student_id,reason,destination,departure_date,return_date,counselor_id,manager_id,apply_date,currentState) values ('$student_id','$reason','$destination','$departure_date','$return_date','$counselor_id','$manager_id','$apply_date','$currentState')";
    if(!$mysqli->query($applyenter)){
        echo"<script>alert('申请失败！请重新填报！');history.back();</script>";
    }
    else {
        echo"<script>alert('申请成功！');window.location.href='/student';</script>";
    }
    $mysqli->close();
}



