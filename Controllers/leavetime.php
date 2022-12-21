<?php
function time2string($second){
    $day = floor($second/(3600*24));
    $second = $second%(3600*24);
    $hour = floor($second/3600);
    $second = $second%3600;
    $minute = floor($second/60);
    $second = $second%60;
    return $day.'天'.$hour.'小时'.$minute.'分'.$second.'秒';
}

function leavetime(){
    $student_id=$_GET["student_id"];
    if($student_id==NULL){
        echo "请输入学号！";
        exit;
    }
    date_default_timezone_set('PRC');
    $currentDate= date("Y-m-d");
    $currentDate=$currentDate." 00:00:00";
    $yearAgoDate= date("Y-m-d", strtotime("-1 year"));
    $yearAgoDate=$yearAgoDate." 00:00:00";
    //连接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $getsuretime="select sum(time) as total_sure from log where log_enter_time>='".$yearAgoDate."' and log_leave_time <='".$currentDate."'";
    $total_sure = $mysqli->query($getsuretime)->fetch_assoc()['total_sure'];
    $getearlytime="select * from log where log_enter_time<'".$yearAgoDate."' and log_leave_time >'".$yearAgoDate."'";
    $early_time=0;
    $ret=$mysqli->query($getearlytime);
    if(mysqli_num_rows($ret)!=0){
        $early_time = $ret->fetch_assoc()['log_leave_time'];
        $early_time=strtotime($early_time)-strtotime($yearAgoDate);
    }
    $getlatetime="select * from log where log_enter_time<'".$currentDate."' and log_leave_time >'".$currentDate."'";
    $late_time=0;
    $ret=$mysqli->query($getlatetime);
    if(mysqli_num_rows($ret)!=0){
        $late_time = $ret->fetch_assoc()['log_enter_time'];
        $late_time=strtotime($currentDate)-strtotime($late_time);
    }
    $total = $late_time+$early_time+$total_sure;
    echo "该学生过去一年总共出校时长：";
    echo time2string(31536000-$total);
    $mysqli->close();
}