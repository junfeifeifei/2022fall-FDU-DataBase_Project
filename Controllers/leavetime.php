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
    echo "自".$yearAgoDate."到".$currentDate."，";
    //连接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $getsuretime="select sum(time) as total_sure from log where log_enter_time>='".$yearAgoDate."' and log_leave_time <='".$currentDate."' and student_id= '".$student_id."'";
    $total_sure = $mysqli->query($getsuretime)->fetch_assoc()['total_sure'];
    $getearlytime="select * from log where log_enter_time<'".$yearAgoDate."' and log_leave_time >'".$yearAgoDate."' and student_id= '".$student_id."'";
    $early_time=0;
    $ret=$mysqli->query($getearlytime);
    if(mysqli_num_rows($ret)!=0){
        $early_time = $ret->fetch_assoc()['log_leave_time'];
        $early_time=strtotime($early_time)-strtotime($yearAgoDate);
    }
    $getlatetime="select * from log where log_enter_time<'".$currentDate."' and ( log_leave_time >'".$currentDate."' or log_leave_time is null) and student_id= '".$student_id."'";
    $late_time=0;
    $ret=$mysqli->query($getlatetime);
    if(mysqli_num_rows($ret)!=0){
        $late_time = $ret->fetch_assoc()['log_enter_time'];
        $late_time=strtotime($currentDate)-strtotime($late_time);
    }
    $total = $late_time+$early_time+$total_sure;//在校总时长
    echo "该学生过去一年总共出校时长：";
    echo time2string(31536000-$total);
    $mysqli->close();
}

function leavetimemax(){
    $depart=$_GET['depart'];
    $class=$_GET['class'];
    $number=$_GET['number'];
    if($depart!='NULL'){
        $ad=" where student.department_name='".$depart."' ";
        if($class!='NULL'&&$class!=NULL){
            $ad=$ad."and student.class_name='".$class."' ";
        }
    }
    else{
        $ad=" ";
    }
    if($number!='NULL'&&$number!=NULL){
        $limt=" limit 0,".$number." ";
    }
    else{
        $limt=" ";
    }
    $get_max="select log.student_id, name, (sum(UNIX_TIMESTAMP(log_enter_time))-sum(UNIX_TIMESTAMP(log_leave_time))-min(UNIX_TIMESTAMP(log_enter_time))+(case when count(log_enter_time)<>count(log_leave_time) then 0 else max(UNIX_TIMESTAMP(log_leave_time)) end))/(count(1)-1) as total_time from log join student on log.student_id=student.student_id ".$ad."group by student_id order by total_time DESC".$limt;
    //链接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $maxALL = $mysqli->query($get_max);
    if(mysqli_num_rows($maxALL)!=0){
        while ($data = mysqli_fetch_assoc($maxALL)){
            echo "<tr>";
            echo '<td border-width="1px">'.$data['student_id'].'</td>';
            echo '<td border-width="1px">'.$data['name'].'</td>';
            if($data['total_time']==NULL){
                $re="只有一条记录,数据不全";
            }
            else{
                $re=time2string($data['total_time']);
            }
            echo '<td border-width="1px">'.$re.'</td>';
            echo '</tr>';
        }
    }
    else{
        echo "<tr><td colspan='3' border-width='1px'>没有找到符合条件的结果</td></tr>";
    }
    $mysqli->close();
}