<?php
function initial_mysql(){
    session_start();
    //链接数据库
    $mysqli = mysqli_connect("localhost","root","1234");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    //创建数据库addmission
    $createDatabase = "create database if not exists admission";
    if(!$mysqli->query($createDatabase)){
        echo"<script>alert('数据库创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //选择数据库admission
    $mysqli->query("use admission");
    //新建校区表
    $createCampus = "create table if not exists campus(
        campus_name varchar(50) UNIQUE NOT NULL primary key,
        state int DEFAULT NULL      
)";
    if(!$mysqli->query($createCampus)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建student表
    $createStudent = "create table if not exists student(
        student_id int UNIQUE NOT NULL primary key,
        name varchar(50) DEFAULT NULL,
        phone_number char(11) DEFAULT NULL,
        email varchar(50) DEFAULT NULL,
        dormitory varchar(50) DEFAULT NULL,
        living_address varchar(50) DEFAULT NULL,
        family_address varchar(50) DEFAULT NULL,
        idcard_type varchar(50) DEFAULT NULL,
        idnumber char(18) DEFAULT NULL,
        belong_campus_name varchar(50) NOT NULL,
        foreign    key(belong_campus_name) references campus(campus_name)        
)";
    if(!$mysqli->query($createStudent)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建teacher表
    $createTeacher = "create table if not exists teacher(
        teacher_id int UNIQUE NOT NULL primary key,
        name varchar(50) DEFAULT NULL,
        authority int DEFAULT NULL
)";
    if(!$mysqli->query($createTeacher)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建院系表
    $createDepart = "create table if not exists department(
        department_name varchar(50) UNIQUE NOT NULL primary key,
        manager_id int NOT NULL,
        foreign    key(manager_id) references teacher(teacher_id)        
)";
    if(!$mysqli->query($createDepart)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建班级表
    $createClass = "create table if not exists class(
        class_name varchar(50) UNIQUE NOT NULL primary key,
        counselor_id int NOT NULL,
        department_name varchar(50) NOT NULL,
        foreign    key(counselor_id) references teacher(teacher_id),        
        foreign    key(department_name) references department(department_name)    
)";
    if(!$mysqli->query($createClass)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }

    //新建进出校记录
    $createLog = "create table if not exists log(
        log_id int UNIQUE NOT NULL primary key,
        log_time DATETIME NOT NULL,
        student_id int NOT NULL,
        campus_name varchar(50) NOT NULL,
        foreign    key(student_id) references student(student_id),        
        foreign    key(campus_name) references campus(campus_name)     
)";
    if(!$mysqli->query($createLog)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建进出校权限表
    $createAccess = "create table if not exists access(
        student_id int UNIQUE NOT NULL, 
        campus_name varchar(50) NOT NULL,
        state int NOT NULL,
        primary key(student_id,campus_name),
        foreign    key(student_id) references student(student_id),        
        foreign    key(campus_name) references campus(campus_name)     
)";
    if(!$mysqli->query($createAccess)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建离校申请表
    $createDeparture = "create table if not exists depart_application(
        application_id int UNIQUE NOT NULL primary key,
        student_id int NOT NULL,
        reason TEXT DEFAULT NULL,
        destination TEXT NOT NULL,
        departure_date  DATETIME NOT NULL,
        return_date  DATETIME NOT NULL,
        counselor_id int NOT NULL,
        manager_id int NOT NULL,
        counselor_approval int DEFAULT NULL,
        manager_approval int DEFAULT NULL,
        manager_reason TEXT DEFAULT NULL,
        counselor_reason TEXT DEFAULT NULL,
        foreign    key(student_id) references student(student_id), 
        foreign    key(counselor_id) references teacher(teacher_id),         
        foreign    key(manager_id) references teacher(teacher_id)       
)";
    if(!$mysqli->query($createDeparture)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建进校申请表
    $createAdmission = "create table if not exists admission_application(
        application_id int UNIQUE NOT NULL primary key,
        student_id int NOT NULL,
        reason TEXT DEFAULT NULL,
        return_date  DATETIME NOT NULL,
        counselor_id int NOT NULL,
        manager_id int NOT NULL,
        counselor_approval int DEFAULT NULL,
        manager_approval int DEFAULT NULL,
        manager_reason TEXT DEFAULT NULL,
        counselor_reason TEXT DEFAULT NULL,
        foreign    key(student_id) references student(student_id), 
        foreign    key(counselor_id) references teacher(teacher_id),         
        foreign    key(manager_id) references teacher(teacher_id)       
)";
    if(!$mysqli->query($createAdmission)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建健康打卡表
    $createDailyHealth = "create table if not exists daily_health(
        daily_health_id int UNIQUE NOT NULL primary key,
        student_id int NOT NULL,
        health_state int NOT NULL,
        record_date  DATETIME NOT NULL,
        record_location varchar(50) NOT NULL,
        temperature float NOT NULL,
        foreign    key(student_id) references student(student_id)    
)";
    if(!$mysqli->query($createDailyHealth)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建班级学生表
    $createCalssmember = "create table if not exists classmember(
    	student_id int UNIQUE NOT NULL,
    	class_name varchar(50) NOT NULL,
    	foreign	key(student_id) references student(student_id), 
        primary key(student_id,class_name),
    	foreign	key(class_name) references class(class_name)    
);";
    if(!$mysqli->query($createCalssmember)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
}