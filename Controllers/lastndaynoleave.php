<?php
function findstu(){
    $depart=$_GET['depart'];
    $class=$_GET['class'];
    $days=$_GET['days'];
    date_default_timezone_set('PRC');
    $currentDate= date("Y-m-d H:i:s");
    $data=date("Y-m-d H:i:s",strtotime("-".$days." days",strtotime($currentDate)));
    if($depart!='NULL'){
        $ad=" and student.department_name='".$depart."' ";
        if($class!='NULL'&&$class!=NULL){
            $ad=$ad."and student.class_name='".$class."' ";
        }
    }
    else{
        $ad=" ";
    }
    $get_max="select student.student_id,student.name from log inner join student on log.student_id=student.student_id where log.log_leave_time is null and log.log_enter_time<'".$data."'".$ad;
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
            echo '</tr>';
        }
    }
    else{
        echo "<tr><td colspan='2' border-width='1px'>没有找到符合条件的结果</td></tr>";
    }
    $mysqli->close();
}