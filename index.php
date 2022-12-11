<?php
error_reporting(0);
session_start();
$url = $_SERVER['REQUEST_URI'];
$urlAfter=parse_url($url);
$path=$urlAfter['path'];

//这里是数据库的初始化代码，需要重置数据库的时候，先丢表，再执行下面的代码即可
//不需重置的时候注释掉就好
//require './Controllers/initialMysql.php';
//initial_mysql();
//dataInsert();


if(!isset($_GET["type"])){//这里面代表的是页面显示部分
    if($path=='/'){
        require 'Views/HTML/Login.html';
    }
    else if($path=="/student"){
        if(!isset($_SESSION['student_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/Student/StudentMain.html';
    }
    else if($path=='/student/leaveapply'){
        if(!isset($_SESSION['student_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/Student/StudentLeaveApply.html';
    }
    else if($path == '/student/enterapply'){
        if(!isset($_SESSION['student_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/Student/StudentEnterApply.html';
    }
    else{
        echo "<script>alert('您访问的页面不存在!');history.back();</script>";
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
