<?php
error_reporting(0);
session_start();
$url = $_SERVER['REQUEST_URI'];
$urlAfter=parse_url($url);
$path=$urlAfter['path'];
if(!isset($_SESSION['initialized'])){
    require './Controllers/initialMysql.php';
    initial_mysql();
    $_SESSION['initialized']=1;
    echo "<script>window.location.href='/';</script>";
}
else{
    if(!isset($_GET["type"])){//这里面代表的是页面显示部分
        if($path == '/'){
            require 'Views/HTML/Login.html';
        }
        if($path == '/student'){
            require 'Views/HTML/Student/StudentMain.html';
        }
        if($path == '/student/leaveapply'){
            require 'Views/HTML/Student/StudentLeaveApply.html';
        }
        if($path == '/student/enterapply'){
            require 'Views/HTML/Student/StudentEnterApply.html';
        }
    }
    else{//这里开始是功能的判断
        $type = $_GET["type"];
        //登录功能
        if($type == "login"){
            require 'Controllers/LoginController.php';
        }
        if($type == "returnToStudent"){
            echo "<script>window.location.href='/student';</script>";
        }
    }
}