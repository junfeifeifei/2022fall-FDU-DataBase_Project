<?php
error_reporting(0);
$url = $_SERVER['REQUEST_URI'];
$urlAfter=parse_url($url);
$path=$urlAfter['path'];
$type = "";

if(!isset($GLOBALS["initialized"])){
    $type = $_GET["type"];
    require 'Controllers/initialMysql.php';
    initial_mysql();
}
else{
    $GLOBALS["initialized"]=1;
    if(isset($_GET["type"])){
        $type = $_GET["type"];
    }
//对于跳转类型的判断
    if($type == "login"){
        require 'Controllers/LoginController.php';
    }
    if($type == "returnToStudent"){
        echo "<script>window.location.href='/student';</script>";
    }
    if($path == '/'){
        require 'Views/HTML/Login.html';
    }
//学生的界面跳转
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