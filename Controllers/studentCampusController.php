<?php
function enterCampusLog(){
    session_start();
    //获取post表单
    $student_id = $_SESSION["student_id"];
    $campus = $_GET["m"];
    if($campus=='h') $campus_name="邯郸校区";
    if($campus=='j') $campus_name="江湾校区";
    if($campus=='z') $campus_name="张江校区";
    if($campus=='f') $campus_name="枫林校区";
    //连接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    //查询是否有权限
    $ifcanenter = "select * from access where student_id='$student_id' and campus_name='$campus_name'";
    $ret=$mysqli->query($ifcanenter);
    if(mysqli_num_rows($ret)==0){
        echo"<script>alert('您暂无权限记录！');history.back();</script>";
    }
    else{
        $row=$ret->fetch_assoc();
        if($row['state']==0){
            echo"<script>alert('您暂无权进入该校区！');history.back();</script>";
            exit;
        }
        date_default_timezone_set('PRC');
        $currentDate= date("Y-m-d H:i:s");
        $logenter="insert into log (student_id,campus_name,log_time) values ('$student_id','$campus_name','$currentDate')";
        if(!$mysqli->query($logenter)){
            echo"<script>alert('进校失败！请重试！');history.back();</script>";
        }
        else {
            echo"<script>alert('进校成功！');window.location.href='/student';</script>";
        }
        $mysqli->close();
    }
}


