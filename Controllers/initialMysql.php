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
        student_id char(11) NOT NULL,
        log_enter_time DATETIME NOT NULL,
        log_enter_campus_name varchar(50) NOT NULL,
        log_leave_time DATETIME DEFAULT NULL,
        log_leave_campus_name varchar(50) DEFAULT NULL,
        time int DEFAULT NULL,
        foreign    key(student_id) references student(student_id),        
        foreign    key(log_enter_campus_name) references campus(campus_name),
        foreign    key(log_leave_campus_name) references campus(campus_name) 
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
//    //插入触发器
//    $timecal="CREATE TRIGGER cal_time AFTER update ON log FOR EACH ROW set new.time = (UNIX_TIMESTAMP(log_enter_time)-UNIX_TIMESTAMP(log_leave_time))";
//    if(!$mysqli->query($timecal)){
//        echo"<script>alert('触发器插入失败！请重新初始化项目');</script>";
//        $mysqli->close();
//        exit;
//    }
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
    ('01011','soft2',3,'123456'),
    ('01012','info2',3,'123456')";
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
    ('2班','01012','信息科学与工程学院'),
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
    ('20300000002','二','18112345678','20300000002@fudan.edu.cn',NULL,NULL,'二代身份证',NULL,'邯郸校区','2班','信息科学与工程学院','123456'),
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
    ('20301234567',1,'2022-12-25 11:23:00','孵蛋大学',37),
    ('20301234567',1,'2022-12-24 11:23:00','孵蛋大学',37),
    ('20301234567',1,'2022-12-23 11:23:00','孵蛋大学',37),
    ('20301234567',1,'2022-12-22 11:23:00','孵蛋大学',37),
    ('20301234567',1,'2022-12-20 11:23:00','孵蛋大学',37),
    ('20300000001',1,'2022-12-24 11:23:00','孵蛋大学',37),
    ('20300000001',1,'2022-12-23 11:23:00','孵蛋大学',37),
    ('20300000001',1,'2022-12-22 11:23:00','孵蛋大学',37),
    ('20300000001',1,'2022-12-21 11:23:00','孵蛋大学',37),
    ('20300000002',1,'2022-12-23 11:23:00','孵蛋大学',37),
    ('20300000002',1,'2022-12-22 11:23:00','孵蛋大学',37),
    ('20300000002',1,'2022-12-21 11:23:00','孵蛋大学',37),
    ('20300000003',1,'2022-12-23 11:23:00','孵蛋大学',37),
    ('20300000003',1,'2022-12-22 11:23:00','孵蛋大学',37),
    ('20300000003',1,'2022-12-21 11:23:00','孵蛋大学',37),
     ('20300000003',1,'2022-12-20 11:23:00','孵蛋大学',37),
    ('20300000003',1,'2022-12-19 11:23:00','孵蛋大学',37),
    ('20300000003',1,'2022-12-18 11:23:00','孵蛋大学',37)
    ";
    if(!$mysqli->query($insert_daily)) {
        echo "<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
//    //插入一些进校记录
    $insert_enter_log="insert ignore into log (student_id,log_enter_time,log_enter_campus_name,log_leave_time,log_leave_campus_name,time) values
    ('20300000001','2022-12-24 11:00:00','邯郸校区',null,null,null),
    ('20300000001','2022-12-23 10:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',10800),
    ('20300000001','2022-12-22 11:00:00','江湾校区','2022-12-22 13:00:00','江湾校区',7200),
    ('20300000001','2022-12-21 11:00:00','江湾校区','2022-12-21 13:00:00','江湾校区',7200),
    ('20300000001','2022-12-20 11:00:00','江湾校区','2022-12-20 13:00:00','江湾校区',7200),
    ('20300000001','2022-12-19 11:00:00','江湾校区','2022-12-19 13:00:00','江湾校区',7200),
    ('20300000001','2022-12-18 11:00:00','江湾校区','2022-12-18 13:00:00','江湾校区',7200),
    ('20300000001','2022-12-17 11:00:00','江湾校区','2022-12-17 13:00:00','江湾校区',7200),
    ('20300000001','2022-12-16 11:00:00','江湾校区','2022-12-16 13:00:00','江湾校区',7200),
    ('20300000001','2022-12-15 11:00:00','江湾校区','2022-12-15 13:00:00','江湾校区',7200),
    ('20300000002','2022-12-24 11:00:00','邯郸校区',null,null,null),
    ('20300000002','2022-12-23 12:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',3600),
    ('20300000002','2022-12-22 11:00:00','江湾校区','2022-12-22 13:00:00','江湾校区',7200),
    ('20300000002','2022-12-21 11:00:00','江湾校区','2022-12-21 13:00:00','江湾校区',7200),
    ('20300000002','2022-12-20 11:00:00','江湾校区','2022-12-20 13:00:00','江湾校区',7200),
    ('20300000002','2022-12-19 11:00:00','江湾校区','2022-12-19 13:00:00','江湾校区',7200),
    ('20300000002','2022-12-18 11:00:00','江湾校区','2022-12-18 13:00:00','江湾校区',7200),
    ('20300000002','2022-12-17 11:00:00','江湾校区','2022-12-17 13:00:00','江湾校区',7200),
    ('20300000002','2022-12-16 12:00:00','江湾校区','2022-12-16 13:00:00','江湾校区',3600),
    ('20300000002','2022-12-15 11:00:00','江湾校区','2022-12-15 13:00:00','江湾校区',7200),
    ('20300000003','2022-12-24 11:00:00','邯郸校区',null,null,null),
    ('20300000003','2022-12-23 12:50:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',600),
    ('20300000003','2022-12-22 11:00:00','江湾校区','2022-12-22 13:00:00','江湾校区',7200),
    ('20300000003','2022-12-21 11:00:00','江湾校区','2022-12-21 13:00:00','江湾校区',7200),
    ('20300000003','2022-12-20 11:00:00','江湾校区','2022-12-20 13:00:00','江湾校区',7200),
    ('20300000003','2022-12-19 11:00:00','江湾校区','2022-12-19 13:00:00','江湾校区',7200),
    ('20300000003','2022-12-18 12:55:00','江湾校区','2022-12-18 13:00:00','江湾校区',300),
    ('20300000003','2022-12-17 11:00:00','江湾校区','2022-12-17 13:00:00','江湾校区',7200),
    ('20300000003','2022-12-16 11:00:00','江湾校区','2022-12-16 13:00:00','江湾校区',7200),
    ('20300000003','2022-12-15 12:30:00','江湾校区','2022-12-15 13:00:00','江湾校区',1800),
    ('20300000004','2022-12-23 11:00:00','邯郸校区',null,null,null),
    ('20300000004','2022-12-22 11:00:00','江湾校区','2022-12-22 13:00:00','江湾校区',7200),
    ('20300000004','2022-12-21 11:00:00','江湾校区','2022-12-21 13:00:00','江湾校区',7200),
    ('20300000004','2022-12-20 11:00:00','江湾校区','2022-12-20 13:00:00','江湾校区',7200),
    ('20300000004','2022-12-19 11:00:00','江湾校区','2022-12-19 13:00:00','江湾校区',7200),
    ('20300000004','2022-12-16 11:00:00','江湾校区','2022-12-16 13:00:00','江湾校区',7200),
    ('20300000004','2022-12-15 11:00:00','江湾校区','2022-12-15 13:00:00','江湾校区',7200),
    ('20300000005','2022-12-22 11:00:00','邯郸校区',null,null,null),
    ('20300000005','2022-12-21 11:00:00','江湾校区','2022-12-21 13:00:00','江湾校区',7200),
    ('20300000005','2022-12-20 11:00:00','江湾校区','2022-12-20 13:00:00','江湾校区',7200),
    ('20300000005','2022-12-19 11:00:00','江湾校区','2022-12-19 13:00:00','江湾校区',7200),
    ('20300000005','2022-12-18 11:00:00','江湾校区','2022-12-18 13:00:00','江湾校区',7200),
    ('20300000005','2022-12-17 11:00:00','江湾校区','2022-12-17 13:00:00','江湾校区',7200),
    ('20300000005','2022-12-16 11:00:00','江湾校区','2022-12-16 13:00:00','江湾校区',7200),
    ('20300000005','2022-12-15 11:00:00','江湾校区','2022-12-15 13:00:00','江湾校区',7200),
    ('20300000006','2022-12-21 11:00:00','邯郸校区',null,null,null),
    ('20300000006','2022-12-20 11:00:00','江湾校区','2022-12-20 13:00:00','江湾校区',7200),
    ('20300000006','2022-12-19 11:00:00','江湾校区','2022-12-19 13:00:00','江湾校区',7200),
    ('20300000006','2022-12-18 11:00:00','江湾校区','2022-12-18 13:00:00','江湾校区',7200),
    ('20300000006','2022-12-17 11:00:00','江湾校区','2022-12-17 13:00:00','江湾校区',7200),
    ('20300000006','2022-12-16 11:00:00','江湾校区','2022-12-16 13:00:00','江湾校区',7200),
    ('20300000006','2022-12-15 11:00:00','江湾校区','2022-12-15 13:00:00','江湾校区',7200),
    ('20300000007','2022-12-19 11:00:00','邯郸校区',null,null,null),
    ('20300000007','2022-12-18 11:00:00','江湾校区','2022-12-18 13:00:00','江湾校区',7200),
    ('20300000007','2022-12-17 11:00:00','江湾校区','2022-12-17 13:00:00','江湾校区',7200),
    ('20300000007','2022-12-16 11:00:00','江湾校区','2022-12-16 13:00:00','江湾校区',7200),
    ('20300000007','2022-12-15 11:00:00','江湾校区','2022-12-15 13:00:00','江湾校区',7200),
    ('20300000008','2022-12-24 11:00:00','邯郸校区',null,null,null),
    ('20300000008','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000008','2022-12-22 11:00:00','江湾校区','2022-12-22 13:00:00','江湾校区',7200),
    ('20300000008','2022-12-21 11:00:00','江湾校区','2022-12-21 13:00:00','江湾校区',7200),
    ('20300000008','2022-12-20 11:00:00','江湾校区','2022-12-20 13:00:00','江湾校区',7200),
    ('20300000008','2022-12-19 11:00:00','江湾校区','2022-12-19 13:00:00','江湾校区',7200),
    ('20300000008','2022-12-18 11:00:00','江湾校区','2022-12-18 13:00:00','江湾校区',7200),
    ('20300000008','2022-12-17 11:00:00','江湾校区','2022-12-17 13:00:00','江湾校区',7200),
    ('20300000008','2022-12-16 11:00:00','江湾校区','2022-12-16 13:00:00','江湾校区',7200),
    ('20300000008','2022-12-15 11:00:00','江湾校区','2022-12-15 13:00:00','江湾校区',7200),
    ('20300000009','2022-12-24 11:00:00','邯郸校区',null,null,null),
    ('20300000009','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000009','2022-12-22 11:00:00','江湾校区','2022-12-22 13:00:00','江湾校区',7200),
    ('20300000009','2022-12-21 11:00:00','江湾校区','2022-12-21 13:00:00','江湾校区',7200),
    ('20300000009','2022-12-20 11:00:00','江湾校区','2022-12-20 13:00:00','江湾校区',7200),
    ('20300000009','2022-12-19 11:00:00','江湾校区','2022-12-19 13:00:00','江湾校区',7200),
    ('20300000009','2022-12-18 11:00:00','江湾校区','2022-12-18 13:00:00','江湾校区',7200),
    ('20300000009','2022-12-17 11:00:00','江湾校区','2022-12-17 13:00:00','江湾校区',7200),
    ('20300000009','2022-12-16 11:00:00','江湾校区','2022-12-16 13:00:00','江湾校区',7200),
    ('20300000009','2022-12-15 11:00:00','江湾校区','2022-12-15 13:00:00','江湾校区',7200),
    ('20300000010','2022-12-24 11:00:00','邯郸校区',null,null,null),
    ('20300000011','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000012','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000012','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000012','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000012','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000012','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000012','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000012','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000012','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000012','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000013','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000013','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000013','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000013','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000013','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000013','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000013','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000013','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000013','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000014','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000014','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000014','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000014','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000014','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000014','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000014','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000014','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000014','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000015','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000015','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000015','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000015','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000015','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000015','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000015','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000015','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000015','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000016','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000016','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000016','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000016','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000016','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000016','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000016','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000016','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000016','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000017','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000017','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000017','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000017','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000017','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000017','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000017','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000017','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000017','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000018','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000018','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000018','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000018','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000018','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000018','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000018','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000018','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000018','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000019','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000019','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000019','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000019','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000019','2022-12-19 1:00:00','张江校区','2022-12-19 13:00:00','张江校区',43200),
    ('20300000019','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000019','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000019','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000019','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000020','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000020','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000020','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000020','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000020','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000020','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000020','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000020','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000020','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000021','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000021','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000021','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000021','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000021','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000021','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000021','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000021','2022-12-16 11:00:00','张江校区','2022-12-16 13:00:00','张江校区',7200),
    ('20300000021','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200),
    ('20300000022','2022-12-23 11:00:00','邯郸校区','2022-12-23 13:00:00','邯郸校区',7200),
    ('20300000022','2022-12-22 11:00:00','张江校区','2022-12-22 13:00:00','张江校区',7200),
    ('20300000022','2022-12-21 11:00:00','张江校区','2022-12-21 13:00:00','张江校区',7200),
    ('20300000022','2022-12-20 11:00:00','张江校区','2022-12-20 13:00:00','张江校区',7200),
    ('20300000022','2022-12-19 11:00:00','张江校区','2022-12-19 13:00:00','张江校区',7200),
    ('20300000022','2022-12-18 11:00:00','张江校区','2022-12-18 13:00:00','张江校区',7200),
    ('20300000022','2022-12-17 11:00:00','张江校区','2022-12-17 13:00:00','张江校区',7200),
    ('20300000022','2022-12-15 11:00:00','张江校区','2022-12-15 13:00:00','张江校区',7200)
    ";
    if(!$mysqli->query($insert_enter_log)) {
        echo "<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    $insert_leave="INSERT INTO `admission`.`depart_application`(`student_id`, `reason`, `destination`, `apply_date`, `departure_date`, `return_date`, `counselor_id`, `manager_id`, `counselor_approval`, `manager_approval`, `manager_reason`, `counselor_reason`) VALUES 
     ('20301234567', '哈哈哈哈', '北京', '2022-12-19', '2023-1-2 16:35:21', '2023-3-31 14:35:33', '01010', '00010', 0, 0, ' ', ' '),
     ('20301234567', '哈哈哈哈', '成都', '2022-12-20', '2023-1-2 16:35:21', '2023-3-31 14:35:33', '01010', '00010', 1, 0, ' ', '好滴'),
     ('20301234567', '哈哈哈哈', 'Los', '2022-12-18', '2023-1-3 16:35:21', '2023-3-31 14:35:33', '01010', '00010', 1, 1, '你说的对', '我觉得没毛病'),
     ('20301234567', '哈哈哈哈', '上海', '2022-12-17', '2023-1-4 16:35:21', '2023-3-31 14:35:33', '01010', '00010', 1, 2, '我觉得不行', '好滴'),
     ('20301234567', '哈哈哈哈', '郑州', '2022-12-16', '2023-1-5 16:35:21', '2023-3-31 14:35:33', '01010', '00010', 2, 0, ' ', '不行'),
     ('20301234568', '哈哈哈哈', '西安', '2022-12-15', '2023-1-6 16:35:21', '2023-3-31 14:35:33', '01006', '00009', 0, 0, ' ', ' '),
     ('20301234568', '哈哈哈哈', '乌鲁木齐', '2022-12-14', '2023-1-7 16:35:21', '2023-3-31 14:35:33', '01006', '00009', 0, 0, ' ', ' '),
     ('20301234568', '哈哈哈哈', '西藏', '2022-12-14', '2023-1-8 16:35:21', '2023-3-31 14:35:33', '01006', '00009', 1, 0, ' ', '你说的对'),
     ('20301234568', '哈哈哈哈', 'London', '2022-12-13', '2023-1-9 16:35:21', '2023-3-31 14:35:33', '01006', '00009', 1, 1, '你说的对', '我觉得没毛病'),
     ('20301234568', '哈哈哈哈', '曹县', '2022-12-12', '2023-1-10 16:35:21', '2023-3-31 14:35:33', '01006', '00009', 1, 2, '不可言', 'okk'),
     ('20301234568', '哈哈哈哈', '齐齐哈尔', '2022-12-11', '2023-1-11 16:35:21', '2023-3-31 14:35:33', '01006', '00009', 2, 0, ' ', '不行'),
     ('20300000001', '哈哈哈哈', '北京', '2022-12-19', '2023-1-2 16:35:21', '2023-3-31 14:35:33', '01001', '00001', 0, 0, ' ', ' '),
     ('20300000007', '哈哈哈哈', '长春', '2022-12-19', '2023-1-2 16:35:21', '2023-3-31 14:35:33', '01004', '00004', 0, 0, ' ', ' '),
     ('20300000008', '哈哈哈哈', '北京', '2022-12-19', '2023-1-2 16:35:21', '2023-3-31 14:35:33', '01004', '00004', 0, 0, ' ', ' ')";
    if(!$mysqli->query($insert_leave)) {
        echo "<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    $insert_admiss="INSERT INTO  admission_application(student_id, reason, apply_date, return_date, counselor_id, manager_id, counselor_approval, manager_approval, manager_reason, counselor_reason,daily_health_id_1,daily_health_id_2,daily_health_id_3,daily_health_id_4,daily_health_id_5,daily_health_id_6,daily_health_id_7) VALUES 
     ('20301234567', '开学啦', '2022-12-25', '2023-3-31 14:35:33', '01010', '00010', 0, 0, ' ', ' ',1,2,3,4,null,5,null),
     ('20301234567', '真的开学啦', '2022-12-25', '2023-3-31 14:35:33', '01010', '00010', 1, 0, '好', ' ',1,2,3,4,null,5,null),
     ('20301234567', '开学我不开心', '2022-12-25', '2023-1-31 14:35:33', '01010', '00010', 2, 0, '不行', ' ',1,2,3,4,null,5,null),
     ('20301234567', '开学怎么办', '2022-12-25', '2023-12-31 14:35:33', '01010', '00010', 1, 1, 'ok', 'okk',1,2,3,4,null,5,null),
     ('20301234567', '开学上网课', '2022-12-25', '2023-1-3 14:35:33', '01010', '00010', 1, 2, 'ok', '不ok',1,2,3,4,null,5,null),
     ('20301234567', '啥时候开学', '2022-12-25', '2023-1-4 14:35:33', '01010', '00010', 2, 0, '不行', ' ',1,2,3,4,null,5,null),
     ('20300000001', '哈哈哈哈1', '2022-12-25', '2023-1-6 16:35:21', '01001', '00001', 0, 0, ' ', ' ',null,6,7,8,9,null,null),
     ('20300000001', '哈哈哈哈2', '2022-12-25', '2023-2-6 16:35:21', '01001', '00001', 1, 0, '欢迎', ' ',null,6,7,8,9,null,null),
     ('20300000001', '哈哈哈哈3', '2022-12-25', '2023-3-6 16:35:21', '01001', '00001', 1, 1, '好', '好',null,6,7,8,9,null,null),
     ('20300000001', '哈哈哈哈4', '2022-12-25', '2023-4-6 16:35:21', '01001', '00001', 1, 2, '好', '不好',null,6,7,8,9,null,null),
     ('20300000001', '哈哈哈哈5', '2022-12-24', '2023-5-6 16:35:21', '01001', '00001', 0, 0, ' ', ' ',6,7,8,9,null,null,null),
     ('20300000001', '哈哈哈哈6', '2022-12-23', '2023-12-6 16:35:21', '01001', '00001', 0, 0, ' ', ' ',7,8,9,null,null,null,null),
     ('20300000002', '哈人1', '2022-12-23', '2023-3-2 16:35:21',  '01012', '00001', 1, 0, 'ok', ' ',10,11,12,null,null,null,null),
     ('20300000002', '哈人2', '2022-12-22', '2023-4-2 16:35:21',  '01012', '00001', 2, 0, '不行', ' ',11,12,null,null,null,null,null),
     ('20300000002', '哈人3', '2022-12-21', '2023-1-2 16:35:21',  '01012', '00001', 0, 0, ' ', ' ',12,null,null,null,null,null,null),  
     ('20300000003', 'no way','2022-12-23', '2023-6-2 16:35:21', '01002', '00002', 0, 0, ' ', ' ',13,14,15,16,17,18,null)";
    if(!$mysqli->query($insert_admiss)) {
        echo "<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    $mysqli->close();
}