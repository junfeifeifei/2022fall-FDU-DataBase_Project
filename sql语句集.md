# 数据库PJ表结构

***买巫予骜 20300290032 &王骏飞 20307130082***

## 一、新建数据库

```sql
create database if not exists admission
use admission
```



## 二、新建表结构

### 1、校区表

```mysql
create table if not exists campus(
        campus_name varchar(50) UNIQUE NOT NULL primary key,
        state int DEFAULT NULL      
)
```



### 2、教师（管理员）表

```sql
create table if not exists teacher(
        teacher_id char(5) UNIQUE NOT NULL primary key,
        name varchar(50) DEFAULT NULL,
        authority int DEFAULT NULL,
        password varchar(50)  NOT NULL
)
```



### 3、院系表

```sql
create table if not exists department(
        department_name varchar(50) UNIQUE NOT NULL primary key,
        manager_id char(5) DEFAULT NULL,
        foreign    key(manager_id) references teacher(teacher_id)        
)
```



### 4、班级表

```sql
create table if not exists class(
        class_name varchar(50) NOT NULL,
        counselor_id char(5) DEFAULT NULL,
        department_name varchar(50) NOT NULL,
        primary key(class_name,department_name),
        foreign    key(counselor_id) references teacher(teacher_id),        
        foreign    key(department_name) references department(department_name)    
)
```



### 5、学生表

```sql
create table if not exists student(
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
)
```



### 6、进出校记录表

```sql
create table if not exists log(
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
)
```



### 7、进出校权限表

```sql
create table if not exists access(
        student_id char(11) NOT NULL, 
        campus_name varchar(50) NOT NULL,
        state int NOT NULL,
        primary key(student_id,campus_name),
        foreign    key(student_id) references student(student_id),        
        foreign    key(campus_name) references campus(campus_name)     
)
```



### 8、离校申请表

```sql
create table if not exists depart_application(
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
)
```



### 9、健康打卡表

```sql
create table if not exists daily_health(
        daily_health_id int primary key auto_increment,
        student_id char(11) NOT NULL,
        health_state int NOT NULL,
        record_date  DATETIME NOT NULL,
        record_location varchar(50) NOT NULL,
        temperature float NOT NULL,
        foreign    key(student_id) references student(student_id)    
)
```



### 10、进校申请表

```sql
create table if not exists admission_application(
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
)
```



## 三、ER关系图

<img src="./数据库ER图.jpg">

