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
        record_date  DATE NOT NULL,
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
    ('01001','aaa',3,'123456'),
    ('01002','bbb',3,'123456'),
    ('01003','ccc',3,'123456'),
    ('01004','ddd',3,'123456'),
    ('01005','eee',3,'123456')";
    if(!$mysqli->query($insert_teacher)){
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
    ('1班','01001','软件学院'),
    ('2班','01002','软件学院'),
    ('3班','01003','软件学院'),
    ('4班','01004','软件学院'),
    ('5班','01005','软件学院'),
    ('1班',NULL,'计算机科学技术学院')";
    if(!$mysqli->query($insert_class)){
        echo"<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    //插入学生
    $insert_student="insert ignore into student (student_id,name,phone_number,email,dormitory,living_address,idcard_type,idnumber,belong_campus_name,class_name,department_name,password) values 
    ('20301234567','张三','18112345678','20301234567@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','软件学院','123456'),
    ('20301234568','李四','18212345678','20301234568@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','1班','计算机科学技术学院','123456')";
    if(!$mysqli->query($insert_student)){
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
    $mysqli->close();
}