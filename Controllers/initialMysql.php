<?php
function initial_mysql(){
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
    //新建teacher表
    $createTeacher = "create table if not exists teacher(
        teacher_id char(5) UNIQUE NOT NULL primary key,
        name varchar(50) DEFAULT NULL,
        authority int DEFAULT NULL,
        password varchar(50)  NOT NULL
)";
    if(!$mysqli->query($createTeacher)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建院系表
    $createDepart = "create table if not exists department(
        department_name varchar(50) UNIQUE NOT NULL primary key,
        manager_id char(5) DEFAULT NULL,
        foreign    key(manager_id) references teacher(teacher_id)        
)";
    if(!$mysqli->query($createDepart)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建班级表
    $createClass = "create table if not exists class(
        class_name varchar(50) NOT NULL,
        counselor_id char(5) DEFAULT NULL,
        department_name varchar(50) NOT NULL,
        primary key(class_name,department_name),
        foreign    key(counselor_id) references teacher(teacher_id),        
        foreign    key(department_name) references department(department_name)    
)";
    if(!$mysqli->query($createClass)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建student表
    $createStudent = "create table if not exists student(
        student_id char(11) UNIQUE NOT NULL primary key,
        name varchar(50) DEFAULT NULL,
        phone_number char(11) DEFAULT NULL,
        email varchar(50) DEFAULT NULL,
        dormitory varchar(50) DEFAULT NULL,
        living_address varchar(50) DEFAULT NULL,
        idcard_type varchar(50) DEFAULT NULL,
        idnumber char(18) DEFAULT NULL,
        belong_campus_name varchar(50) NOT NULL,
        class_name varchar(50)  NOT NULL,
        department_name varchar(50)  NOT NULL,
        password varchar(50)  NOT NULL,
        foreign    key(class_name) references class(class_name),
        foreign    key(department_name) references department(department_name),
        foreign    key(belong_campus_name) references campus(campus_name)        
)";
    if(!$mysqli->query($createStudent)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }

    //新建进出校记录
    $createLog = "create table if not exists log(
        log_id int primary key auto_increment,
        log_time DATETIME NOT NULL,
        student_id char(11) NOT NULL,
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
        student_id char(11) NOT NULL, 
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
        application_id int primary key auto_increment,
        student_id char(11) NOT NULL,
        reason TEXT DEFAULT NULL,
        destination TEXT NOT NULL,
        apply_date  DATE NOT NULL,
        departure_date  DATETIME NOT NULL,
        return_date  DATETIME NOT NULL,
        counselor_id char(5) NOT NULL,
        manager_id char(5) NOT NULL,
        counselor_approval int DEFAULT NULL,
        manager_approval int DEFAULT NULL,
        manager_reason TEXT DEFAULT NULL,
        counselor_reason TEXT DEFAULT NULL,
        currentState int NOT NULL,
        foreign    key(student_id) references student(student_id), 
        foreign    key(counselor_id) references teacher(teacher_id),         
        foreign    key(manager_id) references teacher(teacher_id)       
)";
    if(!$mysqli->query($createDeparture)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //新建健康打卡表
    $createDailyHealth = "create table if not exists daily_health(
        daily_health_id int primary key auto_increment,
        student_id char(11) NOT NULL,
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
    //新建进校申请表
    $createAdmission = "create table if not exists admission_application(
        application_id int primary key auto_increment,
        student_id char(11) NOT NULL,
        reason TEXT DEFAULT NULL,
        return_date  DATETIME NOT NULL,
        apply_date  DATE NOT NULL,
        counselor_id char(5) NOT NULL,
        manager_id char(5) NOT NULL,
        counselor_approval int DEFAULT NULL,
        manager_approval int DEFAULT NULL,
        manager_reason TEXT DEFAULT NULL,
        counselor_reason TEXT DEFAULT NULL,
        daily_health_id_1 int DEFAULT NULL,
        daily_health_id_2 int DEFAULT NULL,
        daily_health_id_3 int DEFAULT NULL,
        daily_health_id_4 int DEFAULT NULL,
        daily_health_id_5 int DEFAULT NULL,
        daily_health_id_6 int DEFAULT NULL,
        daily_health_id_7 int DEFAULT NULL,
        currentState int NOT NULL,
        foreign    key(daily_health_id_1) references daily_health(daily_health_id), 
        foreign    key(daily_health_id_2) references daily_health(daily_health_id), 
        foreign    key(daily_health_id_3) references daily_health(daily_health_id), 
        foreign    key(daily_health_id_4) references daily_health(daily_health_id),  
        foreign    key(daily_health_id_5) references daily_health(daily_health_id), 
        foreign    key(daily_health_id_6) references daily_health(daily_health_id), 
        foreign    key(daily_health_id_7) references daily_health(daily_health_id), 
        foreign    key(student_id) references student(student_id), 
        foreign    key(counselor_id) references teacher(teacher_id), 
        foreign    key(manager_id) references teacher(teacher_id)       
)";
    if(!$mysqli->query($createAdmission)){
        echo"<script>alert('数据表创建失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    $mysqli->close();
}


function dataInsert(){
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    //插入校区
    $insert_campus="insert ignore into campus (campus_name,state) values ('邯郸校区',0),('江湾校区',0),('张江校区',0),('枫林校区',0)";
    if(!$mysqli->query($insert_campus)){
        echo"<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入老师
    $insert_teacher="insert ignore into teacher (teacher_id,name,authority,password) values 
    ('01001','info1',3,'123456'),
    ('01002','medical1',3,'123456'),
    ('01003','datascience1',3,'123456'),
    ('01004','micro1',3,'123456'),
    ('01005','jour1',3,'123456'),
    ('01006','law1',3,'123456'),
    ('01007','manage1',3,'123456'),
    ('01008','econ1',3,'123456'),
    ('01009','comp1',3,'123456'),
    ('01010','soft1',3,'123456'),
    ('01011','soft2',3,'123456')";
    if(!$mysqli->query($insert_teacher)){
        echo"<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入院系管理员
    $insert_admin="insert ignore into teacher (teacher_id,name,authority,password) values 
    ('00001','info',2,'123456'),
    ('00002','medical',2,'123456'),
    ('00003','datascience',2,'123456'),
    ('00004','micro',2,'123456'),
    ('00005','jour',2,'123456'),
    ('00006','law',2,'123456'),
    ('00007','manage',2,'123456'),
    ('00008','econ',2,'123456'),
    ('00009','comp',2,'123456'),
    ('00010','soft',2,'123456')";
    if(!$mysqli->query($insert_admin)){
        echo"<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入院系
    $insert_department="insert ignore into department (department_name,manager_id) values
    ('软件学院','00010'),
    ('计算机科学技术学院','00009'),
    ('微电子学院','00004'),
    ('信息科学与工程学院','00001'),
    ('大数据学院','00003'),
    ('法学院','00006'),
    ('经济学院','00008'),
    ('管理学院','00007'),
    ('新闻学院','00005'),
    ('基础医学院','00002')";
    if(!$mysqli->query($insert_department)){
        echo"<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入班级
    $insert_class="insert ignore into class (class_name,counselor_id,department_name) values 
    ('1班','01001','信息科学与工程学院'),
    ('1班','01002','基础医学院'),
    ('1班','01003','大数据学院'),
    ('1班','01004','微电子学院'),
    ('1班','01005','新闻学院'),
    ('1班','01006','法学院'),
    ('1班','01007','管理学院'),
    ('1班','01008','经济学院'),
    ('1班','01009','计算机科学技术学院'),
    ('1班','01010','软件学院'),
    ('2班','01011','软件学院')";
    if(!$mysqli->query($insert_class)){
        echo"<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入学生
    $insert_student="insert ignore into student (student_id,name,phone_number,email,dormitory,living_address,idcard_type,idnumber,belong_campus_name,class_name,department_name,password) values 
    ('20301234567','张三','18112345678','20301234567@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','软件学院','123456'),
    ('20301234568','李四','18212345678','20301234568@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','计算机科学技术学院','123456'),
    ('20300000001','一','18112345678','20300000001@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','信息科学与工程学院','123456'),
    ('20300000002','二','18112345678','20300000002@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','信息科学与工程学院','123456'),
    ('20300000003','三','18112345678','20300000003@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','基础医学院','123456'),
    ('20300000004','四','18112345678','20300000004@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','基础医学院','123456'),
    ('20300000005','五','18112345678','20300000005@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','大数据学院','123456'),
    ('20300000006','六','18112345678','20300000006@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','大数据学院','123456'),
    ('20300000007','七','18112345678','20300000007@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','微电子学院','123456'),
    ('20300000008','八','18112345678','20300000008@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','微电子学院','123456'),
    ('20300000009','九','18112345678','20300000009@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','新闻学院','123456'),
    ('20300000010','十','18112345678','20300000010@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','新闻学院','123456'),
    ('20300000011','十一','18112345678','20300000011@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','法学院','123456'),
    ('20300000012','十二','18112345678','20300000012@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','法学院','123456'),
    ('20300000013','十三','18112345678','20300000013@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','管理学院','123456'),
    ('20300000014','十四','18112345678','20300000014@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','管理学院','123456'),
    ('20300000015','十五','18112345678','20300000015@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','经济学院','123456'),
    ('20300000016','十六','18112345678','20300000016@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','经济学院','123456'),
    ('20300000017','十七','18112345678','20300000017@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','计算机科学技术学院','123456'),
    ('20300000018','十八','18112345678','20300000018@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','计算机科学技术学院','123456'),
    ('20300000019','十九','18112345678','20300000019@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','软件学院','123456'),
    ('20300000020','二十','18112345678','20300000020@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','软件学院','123456'),  
    ('20300000021','二十一','18112345678','20300000019@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','2班','软件学院','123456'),
    ('20300000022','二十二','18112345678','20300000019@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','2班','软件学院','123456')";
    if(!$mysqli->query($insert_student)){
        echo"<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入学生进校权限
    $insert_access="insert ignore into access (student_id,campus_name,state) values ('20301234567','邯郸校区',1),
    ('20301234567','江湾校区',1),
    ('20301234567','张江校区',1),
    ('20301234567','枫林校区',0),
    ('20301234568','邯郸校区',0),
    ('20301234568','江湾校区',0),
    ('20301234568','张江校区',0),
    ('20301234568','枫林校区',0)";
    if(!$mysqli->query($insert_access)) {
        echo "<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入超级管理员
    $insert_superadmin="insert ignore into teacher (teacher_id,name,authority,password) values ('00000','root',1,'123456')";
    if(!$mysqli->query($insert_superadmin)) {
        echo "<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入一些打卡记录
    $insert_daily="insert ignore into daily_health (student_id,health_state,record_date,record_location,temperature) values 
    ('20301234567',1,'2022-12-15 11:23:00','孵蛋大学',37),
    ('20301234567',1,'2022-12-14 11:23:00','孵蛋大学',37),
    ('20301234567',1,'2022-12-12 11:23:00','孵蛋大学',37),
    ('20301234567',1,'2022-12-11 11:23:00','孵蛋大学',37),
    ('20301234567',1,'2022-12-10 11:23:00','孵蛋大学',37)";
    if(!$mysqli->query($insert_daily)) {
        echo "<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入一些进校记录
    $insert_log="insert ignore into log (log_time,student_id,campus_name) values 
    ('2022-12-23 11:23:00','20300000001','邯郸校区'),
    ('2022-12-22 11:23:00','20300000001','邯郸校区'),
    ('2022-12-21 11:23:00','20300000001','江湾校区'),
    ('2022-12-20 11:23:00','20300000001','邯郸校区'),
    ('2022-12-19 11:23:00','20300000001','张江校区'),
    ('2022-12-18 11:23:00','20300000001','张江校区'),
    ('2022-12-17 11:23:00','20300000001','张江校区'),
    ('2022-12-16 11:23:00','20300000001','张江校区'),
    ('2022-12-15 11:23:00','20300000001','张江校区'),
    ('2022-12-14 11:23:00','20300000001','张江校区'),
    ('2022-12-23 11:23:00','20300000002','邯郸校区'),
    ('2022-12-22 11:23:00','20300000002','邯郸校区'),
    ('2022-12-21 11:23:00','20300000002','江湾校区'),
    ('2022-12-20 11:23:00','20300000002','邯郸校区'),
    ('2022-12-19 11:23:00','20300000002','张江校区'),
    ('2022-12-18 11:23:00','20300000002','张江校区'),
    ('2022-12-17 11:23:00','20300000002','张江校区'),
    ('2022-12-16 11:23:00','20300000002','张江校区'),
    ('2022-12-15 11:23:00','20300000002','张江校区'),
    ('2022-12-14 11:23:00','20300000002','张江校区'),
    ('2022-12-23 11:23:00','20300000003','邯郸校区'),
    ('2022-12-22 11:23:00','20300000003','邯郸校区'),
    ('2022-12-21 11:23:00','20300000003','江湾校区'),
    ('2022-12-20 11:23:00','20300000003','邯郸校区'),
    ('2022-12-19 11:23:00','20300000003','张江校区'),
    ('2022-12-18 11:23:00','20300000003','张江校区'),
    ('2022-12-17 11:23:00','20300000003','张江校区'),
    ('2022-12-16 11:23:00','20300000003','张江校区'),
    ('2022-12-15 11:23:00','20300000003','张江校区'),
    ('2022-12-14 11:23:00','20300000003','张江校区'),
    ('2022-12-23 11:23:00','20300000004','邯郸校区'),
    ('2022-12-22 11:23:00','20300000004','邯郸校区'),
    ('2022-12-21 11:23:00','20300000004','江湾校区'),
    ('2022-12-20 11:23:00','20300000004','邯郸校区'),
    ('2022-12-19 11:23:00','20300000004','张江校区'),
    ('2022-12-18 11:23:00','20300000004','张江校区'),
    ('2022-12-17 11:23:00','20300000004','张江校区'),
    ('2022-12-16 11:23:00','20300000004','张江校区'),
    ('2022-12-15 11:23:00','20300000004','张江校区'),
    ('2022-12-14 11:23:00','20300000004','张江校区'),
    ('2022-12-23 11:23:00','20300000005','邯郸校区'),
    ('2022-12-22 11:23:00','20300000005','邯郸校区'),
    ('2022-12-21 11:23:00','20300000005','江湾校区'),
    ('2022-12-20 11:23:00','20300000005','邯郸校区'),
    ('2022-12-19 11:23:00','20300000005','张江校区'),
    ('2022-12-18 11:23:00','20300000005','张江校区'),
    ('2022-12-17 11:23:00','20300000005','张江校区'),
    ('2022-12-16 11:23:00','20300000005','张江校区'),
    ('2022-12-15 11:23:00','20300000005','张江校区'),
    ('2022-12-14 11:23:00','20300000005','张江校区'),
    ('2022-12-23 11:23:00','20300000006','邯郸校区'),
    ('2022-12-22 11:23:00','20300000006','邯郸校区'),
    ('2022-12-21 11:23:00','20300000006','江湾校区'),
    ('2022-12-20 11:23:00','20300000006','邯郸校区'),
    ('2022-12-19 11:23:00','20300000006','张江校区'),
    ('2022-12-18 11:23:00','20300000006','张江校区'),
    ('2022-12-17 11:23:00','20300000006','张江校区'),
    ('2022-12-16 11:23:00','20300000006','张江校区'),
    ('2022-12-15 11:23:00','20300000006','张江校区'),
    ('2022-12-14 11:23:00','20300000006','张江校区'),
    ('2022-12-23 11:23:00','20300000007','邯郸校区'),
    ('2022-12-22 11:23:00','20300000007','邯郸校区'),
    ('2022-12-21 11:23:00','20300000007','江湾校区'),
    ('2022-12-20 11:23:00','20300000007','邯郸校区'),
    ('2022-12-19 11:23:00','20300000007','张江校区'),
    ('2022-12-18 11:23:00','20300000007','张江校区'),
    ('2022-12-17 11:23:00','20300000007','张江校区'),
    ('2022-12-16 11:23:00','20300000007','张江校区'),
    ('2022-12-15 11:23:00','20300000007','张江校区'),
    ('2022-12-14 11:23:00','20300000007','张江校区'),
    ('2022-12-23 11:23:00','20300000008','邯郸校区'),
    ('2022-12-22 11:23:00','20300000008','邯郸校区'),
    ('2022-12-21 11:23:00','20300000008','江湾校区'),
    ('2022-12-20 11:23:00','20300000008','邯郸校区'),
    ('2022-12-19 11:23:00','20300000008','张江校区'),
    ('2022-12-18 11:23:00','20300000008','张江校区'),
    ('2022-12-17 11:23:00','20300000008','张江校区'),
    ('2022-12-16 11:23:00','20300000008','张江校区'),
    ('2022-12-15 11:23:00','20300000008','张江校区'),
    ('2022-12-14 11:23:00','20300000008','张江校区'),
    ('2022-12-23 11:23:00','20300000009','邯郸校区'),
    ('2022-12-22 11:23:00','20300000009','邯郸校区'),
    ('2022-12-21 11:23:00','20300000009','江湾校区'),
    ('2022-12-20 11:23:00','20300000009','邯郸校区'),
    ('2022-12-19 11:23:00','20300000009','张江校区'),
    ('2022-12-18 11:23:00','20300000009','张江校区'),
    ('2022-12-17 11:23:00','20300000009','张江校区'),
    ('2022-12-16 11:23:00','20300000009','张江校区'),
    ('2022-12-15 11:23:00','20300000009','张江校区'),
    ('2022-12-14 11:23:00','20300000009','张江校区'),
    ('2022-12-23 11:23:00','20300000010','邯郸校区'),
    ('2022-12-22 11:23:00','20300000010','邯郸校区'),
    ('2022-12-21 11:23:00','20300000010','江湾校区'),
    ('2022-12-20 11:23:00','20300000010','邯郸校区'),
    ('2022-12-19 11:23:00','20300000010','张江校区'),
    ('2022-12-18 11:23:00','20300000010','张江校区'),
    ('2022-12-17 11:23:00','20300000010','张江校区'),
    ('2022-12-16 11:23:00','20300000010','张江校区'),
    ('2022-12-15 11:23:00','20300000010','张江校区'),
    ('2022-12-14 11:23:00','20300000010','张江校区'),
    ('2022-12-23 11:23:00','20300000011','邯郸校区'),
    ('2022-12-22 11:23:00','20300000011','枫林校区'),
    ('2022-12-21 11:23:00','20300000011','枫林校区'),
    ('2022-12-20 11:23:00','20300000011','江湾校区'),
    ('2022-12-19 11:23:00','20300000011','江湾校区'),
    ('2022-12-18 11:23:00','20300000011','江湾校区'),
    ('2022-12-17 11:23:00','20300000011','江湾校区'),
    ('2022-12-16 11:23:00','20300000011','江湾校区'),
    ('2022-12-15 11:23:00','20300000011','江湾校区'),
    ('2022-12-14 11:23:00','20300000011','江湾校区'),
    ('2022-12-23 11:23:00','20300000012','邯郸校区'),
    ('2022-12-22 11:23:00','20300000012','枫林校区'),
    ('2022-12-21 11:23:00','20300000012','枫林校区'),
    ('2022-12-20 11:23:00','20300000012','江湾校区'),
    ('2022-12-19 11:23:00','20300000012','江湾校区'),
    ('2022-12-18 11:23:00','20300000012','江湾校区'),
    ('2022-12-17 11:23:00','20300000012','江湾校区'),
    ('2022-12-16 11:23:00','20300000012','江湾校区'),
    ('2022-12-15 11:23:00','20300000012','江湾校区'),
    ('2022-12-14 11:23:00','20300000012','江湾校区'),
    ('2022-12-23 11:23:00','20300000013','邯郸校区'),
    ('2022-12-22 11:23:00','20300000013','枫林校区'),
    ('2022-12-21 11:23:00','20300000013','枫林校区'),
    ('2022-12-20 11:23:00','20300000013','江湾校区'),
    ('2022-12-19 11:23:00','20300000013','江湾校区'),
    ('2022-12-18 11:23:00','20300000013','江湾校区'),
    ('2022-12-17 11:23:00','20300000013','江湾校区'),
    ('2022-12-16 11:23:00','20300000013','江湾校区'),
    ('2022-12-15 11:23:00','20300000013','江湾校区'),
    ('2022-12-14 11:23:00','20300000013','江湾校区'),
    ('2022-12-23 11:23:00','20300000014','邯郸校区'),
    ('2022-12-22 11:23:00','20300000014','枫林校区'),
    ('2022-12-21 11:23:00','20300000014','枫林校区'),
    ('2022-12-20 11:23:00','20300000014','江湾校区'),
    ('2022-12-19 11:23:00','20300000014','江湾校区'),
    ('2022-12-18 11:23:00','20300000014','江湾校区'),
    ('2022-12-17 11:23:00','20300000014','江湾校区'),
    ('2022-12-16 11:23:00','20300000014','江湾校区'),
    ('2022-12-15 11:23:00','20300000014','江湾校区'),
    ('2022-12-14 11:23:00','20300000014','江湾校区'),
    ('2022-12-23 11:23:00','20300000015','邯郸校区'),
    ('2022-12-22 11:23:00','20300000015','枫林校区'),
    ('2022-12-21 11:23:00','20300000015','枫林校区'),
    ('2022-12-20 11:23:00','20300000015','江湾校区'),
    ('2022-12-19 11:23:00','20300000015','江湾校区'),
    ('2022-12-18 11:23:00','20300000015','江湾校区'),
    ('2022-12-17 11:23:00','20300000015','江湾校区'),
    ('2022-12-16 11:23:00','20300000015','江湾校区'),
    ('2022-12-15 11:23:00','20300000015','江湾校区'),
    ('2022-12-14 11:23:00','20300000015','江湾校区'),
    ('2022-12-23 11:23:00','20300000016','邯郸校区'),
    ('2022-12-22 11:23:00','20300000016','枫林校区'),
    ('2022-12-21 11:23:00','20300000016','枫林校区'),
    ('2022-12-20 11:23:00','20300000016','江湾校区'),
    ('2022-12-19 11:23:00','20300000016','江湾校区'),
    ('2022-12-18 11:23:00','20300000016','江湾校区'),
    ('2022-12-17 11:23:00','20300000016','江湾校区'),
    ('2022-12-16 11:23:00','20300000016','江湾校区'),
    ('2022-12-15 11:23:00','20300000016','江湾校区'),
    ('2022-12-14 11:23:00','20300000016','江湾校区'),
    ('2022-12-23 11:23:00','20300000017','邯郸校区'),
    ('2022-12-22 11:23:00','20300000017','枫林校区'),
    ('2022-12-21 11:23:00','20300000017','枫林校区'),
    ('2022-12-20 11:23:00','20300000017','江湾校区'),
    ('2022-12-19 11:23:00','20300000017','江湾校区'),
    ('2022-12-18 11:23:00','20300000017','江湾校区'),
    ('2022-12-17 11:23:00','20300000017','江湾校区'),
    ('2022-12-16 11:23:00','20300000017','江湾校区'),
    ('2022-12-15 11:23:00','20300000017','江湾校区'),
    ('2022-12-14 11:23:00','20300000017','江湾校区'),
    ('2022-12-23 11:23:00','20300000018','邯郸校区'),
    ('2022-12-22 11:23:00','20300000018','枫林校区'),
    ('2022-12-21 11:23:00','20300000018','枫林校区'),
    ('2022-12-20 11:23:00','20300000018','江湾校区'),
    ('2022-12-19 11:23:00','20300000018','江湾校区'),
    ('2022-12-18 11:23:00','20300000018','江湾校区'),
    ('2022-12-17 11:23:00','20300000018','江湾校区'),
    ('2022-12-16 11:23:00','20300000018','江湾校区'),
    ('2022-12-15 11:23:00','20300000018','江湾校区'),
    ('2022-12-14 11:23:00','20300000018','江湾校区'),
    ('2022-12-23 11:23:00','20300000019','邯郸校区'),
    ('2022-12-22 11:23:00','20300000019','枫林校区'),
    ('2022-12-21 11:23:00','20300000019','枫林校区'),
    ('2022-12-20 11:23:00','20300000019','江湾校区'),
    ('2022-12-19 11:23:00','20300000019','江湾校区'),
    ('2022-12-18 11:23:00','20300000019','江湾校区'),
    ('2022-12-17 11:23:00','20300000019','江湾校区'),
    ('2022-12-16 11:23:00','20300000019','江湾校区'),
    ('2022-12-15 11:23:00','20300000019','江湾校区'),
    ('2022-12-14 11:23:00','20300000019','江湾校区'),
    ('2022-12-23 11:23:00','20300000020','邯郸校区'),
    ('2022-12-22 11:23:00','20300000020','枫林校区'),
    ('2022-12-21 11:23:00','20300000020','枫林校区'),
    ('2022-12-20 11:23:00','20300000020','江湾校区'),
    ('2022-12-19 11:23:00','20300000020','江湾校区'),
    ('2022-12-18 11:23:00','20300000020','江湾校区'),
    ('2022-12-17 11:23:00','20300000020','江湾校区'),
    ('2022-12-16 11:23:00','20300000020','江湾校区'),
    ('2022-12-15 11:23:00','20300000020','江湾校区'),
    ('2022-12-14 11:23:00','20300000020','江湾校区')";
    if(!$mysqli->query($insert_log)) {
        echo "<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    $insert_leave="INSERT INTO `admission`.`depart_application`(`student_id`, `reason`, `destination`, `apply_date`, `departure_date`, `return_date`, `counselor_id`, `manager_id`, `counselor_approval`, `manager_approval`, `manager_reason`, `counselor_reason`, `currentState`) VALUES ('20301234567', '哈哈哈哈', '北京', '2022-12-19', '2022-1-2 16:35:21', '2022-3-31 14:35:33', '01010', '00010', 0, 0, ' ', ' ', 1),('20301234567', '哈哈哈哈', '成都', '2022-12-20', '2022-1-2 16:35:21', '2022-3-31 14:35:33', '01010', '00010', 1, 0, ' ', '好滴', 2),('20301234567', '哈哈哈哈', 'Los', '2022-12-18', '2022-1-3 16:35:21', '2022-3-31 14:35:33', '01010', '00010', 1, 1, '你说的对', '我觉得没毛病', 3),('20301234567', '哈哈哈哈', '上海', '2022-12-17', '2022-1-4 16:35:21', '2022-3-31 14:35:33', '01010', '00010', 1, 2, '我觉得不行', '好滴', 4),('20301234567', '哈哈哈哈', '郑州', '2022-12-16', '2022-1-5 16:35:21', '2022-3-31 14:35:33', '01010', '00010', 2, 0, ' ', '不行', 5),('20301234568', '哈哈哈哈', '西安', '2022-12-15', '2022-1-6 16:35:21', '2022-3-31 14:35:33', '01006', '00009', 0, 0, ' ', ' ', 1),('20301234568', '哈哈哈哈', '乌鲁木齐', '2022-12-14', '2022-1-7 16:35:21', '2022-3-31 14:35:33', '01006', '00009', 0, 0, ' ', ' ', 1),('20301234568', '哈哈哈哈', '西藏', '2022-12-14', '2022-1-8 16:35:21', '2022-3-31 14:35:33', '01006', '00009', 1, 0, ' ', '你说的对', 2),('20301234568', '哈哈哈哈', 'London', '2022-12-13', '2022-1-9 16:35:21', '2022-3-31 14:35:33', '01006', '00009', 1, 1, '你说的对', '我觉得没毛病', 3),('20301234568', '哈哈哈哈', '曹县', '2022-12-12', '2022-1-10 16:35:21', '2022-3-31 14:35:33', '01006', '00009', 1, 2, '不可言', 'okk', 4),('20301234568', '哈哈哈哈', '齐齐哈尔', '2022-12-11', '2022-1-11 16:35:21', '2022-3-31 14:35:33', '01006', '00009', 2, 0, ' ', '不行', 5)";
    if(!$mysqli->query($insert_leave)) {
        echo "<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    $mysqli->close();
}