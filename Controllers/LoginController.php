<?php
session_start();
$inputId = "";
$inputPassword = "";
//获取post表单
if(isset($_POST["inputId"])){
    $inputId = $_POST["inputId"];
}
if(isset($_POST["inputPassword"])){
    $inputPassword = $_POST["inputPassword"];
}
//连接数据库
$mysqli = mysqli_connect("localhost","root","1234","admission");
if(!$mysqli){
    echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
    exit;
}
//学生登录
if(strlen($inputId)==11){
    $getUserInform = "select * from student where student_id='$inputId'";
    $userInform=$mysqli->query($getUserInform);
    if(!mysqli_num_rows($userInform)){
        $userInform->free();
        $mysqli->close();
        echo"<script>alert('学号不存在！请重新输入！');history.back();</script>";
        exit;
    }
    $passwd = $userInform->fetch_assoc()['password'];
    if($passwd==$inputPassword){
        $_SESSION['student_id']=$inputId;
        $userInform->free();
        $mysqli->close();
        echo"<script>alert('登陆成功！');window.location.href='/student';</script>";
        exit;
    }
    else{
        $userInform->free();
        $mysqli->close();
        echo"<script>alert('密码输入错误！请重新输入！');history.back();</script>";
        exit;
    }
}
//教师登录
else if(strlen($inputId)==5){
    $getUserInform = "select * from teacher where teacher_id='$inputId'";
    $userInform=$mysqli->query($getUserInform);
    if(!mysqli_num_rows($userInform)){
        $userInform->free();
        $mysqli->close();
        echo"<script>alert('工号不存在！请重新输入！');history.back();</script>";
        exit;
    }
    $passwd = $userInform->fetch_assoc()['password'];
    if($passwd==$inputPassword){
        $_SESSION['teacher_id']=$inputId;
        $userInform->free();
        $mysqli->close();
        echo"<script>alert('登陆成功！');window.location.href='/teacher';</script>";
        exit;
    }
    else{
        $userInform->free();
        $mysqli->close();
        echo"<script>alert('密码输入错误！请重新输入！');history.back();</script>";
        exit;
    }
}
//学工号错误
else{
    echo"<script>alert('请输入正确的学号或工号！');history.back();</script>";
    $mysqli->close();
    exit;
}

