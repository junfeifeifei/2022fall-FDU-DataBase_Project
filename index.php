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
    //主页面
    if($path=='/'){
        require 'Views/HTML/Login.html';
    }
    //学生的页面
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
    //辅导员的界面
    else if($path == '/tutor'){
        if(!isset($_SESSION['teacher_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/Tutor/TutorMain.html';
    }
    //院系管理员的页面
    else if($path == '/admin'){
        if(!isset($_SESSION['teacher_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/Admin/AdminMain.html';
    }
    //超级管理员的界面
    else if($path == '/superadmin'){
        if(!isset($_SESSION['teacher_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/SuperAdmin/SuperAdminMain.html';
    }
    else if($path == '/superadmin'){
        if(!isset($_SESSION['teacher_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/SuperAdmin/SuperAdminMain.html';
    }
    else if($path == '/superadmin/studentinfo'){
        if(!isset($_SESSION['teacher_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/SuperAdmin/SuperAdminStudentInfo.php';
    }
    else if($path == '/superadmin/teacherinfo'){
        if(!isset($_SESSION['teacher_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/SuperAdmin/SuperAdminTeacherInfo.php';
    }
    else if($path == '/superadmin/addstudent'){
        if(!isset($_SESSION['teacher_id'])){
            echo"<script>alert('您无权访问该页面');history.back();</script>";
        }
        else require 'Views/HTML/SuperAdmin/SuperAdminAddStudent.php';
    }


    else{
        echo "<script>alert('您访问的页面不存在!');history.back();</script>";
    }
}
else{//这里开始是功能的判断
    $type = $_GET["type"];
    //登录功能
    if($type == "login"){
        require 'Controllers/Login&outController.php';
        login();
    }
    else if($type == "logout"){
        require 'Controllers/Login&outController.php';
        logout();
    }
    else if($type == "returnToStudent"){
        echo "<script>window.location.href='/student';</script>";
    }
    //超级管理员功能
    else if($type == "addstudent"){
        require 'Controllers/SuperAdminAddStudent.php';
    }
}
