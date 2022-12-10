```sql
create database if not exists admiss [default charset utf-8];
use admiss;
```

用户表：老师学生管理员，超管写死

```sql
create table if not exists student(
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
		foreign	key(belong_campus_name) references campus(campus_name)    	
);
```

**属性：主键：id（学生8，老师5，管理员4？），其他：name，phonenum，email，domitory，livingaddr，familyaddr，idcardtype，idcardnum**

```sql
create table if not exists teacher(
        teacher_id int UNIQUE NOT NULL primary key,
        name varchar(50) DEFAULT NULL,
        authority int DEFAULT NULL,
    	department_id int DEFAULT NULL,
    	class_id int DEFAULT NULL,
		foreign	key(department_id) references department(department_id),
    	foreign	key(class_id) references class(class_id)    	
);
```

院系表：院系基本信息+管理员名称 **属性：主键：院系id：dept_id，其他：dept_name，admin_id**

```sql
create table if not exists department(
        department_name varchar(50) UNIQUE NOT NULL primary key,
    	manager_id int NOT NULL,
		foreign	key(manager_id) references teacher(teacher_id)    	
);
```

班级表：班级基本信息（包含院系）+辅导员

```sql
create table if not exists class(
        class_name varchar(50) UNIQUE NOT NULL primary key,
    	counselor_id int NOT NULL,
    	department_name varchar(50) NOT NULL,
		foreign	key(counselor_id) references teacher(teacher_id),    	
    	foreign	key(department_name) references department(department_name)    
);
```

校区表：**属性：名字和状态**

```sql
create table if not exists campus(
        campus_name varchar(50) UNIQUE NOT NULL primary key,
        state int DEFAULT NULL  	
);
```

进出表：**属性：学生id，校区id，时间，是进还是出**

```sql
create table if not exists log(
    	log_id int UNIQUE NOT NULL primary key,
        log_time DATETIME NOT NULL,
    	student_id int NOT NULL,
    	campus_name varchar(50) NOT NULL,
        foreign	key(student_id) references student(student_id),    	
    	foreign	key(campus_name) references campus(campus_name) 	
);
```

权限表：**属性：学生id，校区id，是否有权限**

```sql
create table if not exists access(
    	student_id int UNIQUE NOT NULL primary key,
    	campus_name varchar(50) NOT NULL primary key,
    	state int NOT NULL,
        foreign	key(student_id) references student(student_id),    	
    	foreign	key(campus_name) references campus(campus_name) 	
);
```

出校申请表：**属性：applyid（pk）**

```sql
create table if not exists depart_application(
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
    	foreign	key(student_id) references student(student_id), 
        foreign	key(counselor_id) references teacher(teacher_id),     	
    	foreign	key(manager_id) references teacher(teacher_id)   	
);
```

进校申请表：
```sql
create table if not exists admission_application(
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
    	foreign	key(student_id) references student(student_id), 
        foreign	key(counselor_id) references teacher(teacher_id),     	
    	foreign	key(manager_id) references teacher(teacher_id)   	
);
```


打卡表：**属性：记录id**

```sql
create table if not exists daily_health(
    	daily_health_id int UNIQUE NOT NULL primary key,
    	student_id int NOT NULL,
    	health_state int NOT NULL,
    	record_date  DATETIME NOT NULL,
    	record_location varchar(50) NOT NULL,
    	temperature float NOT NULL,
    	foreign	key(student_id) references student(student_id),  	
);
```

班级学生关系表：

```sql
create table if not exists classmember(
    	student_id int UNIQUE NOT NULL primary key,
    	class_name varchar(50) NOT NULL primary key,
    	foreign	key(student_id) references student(student_id),  	
    	foreign	key(class_name) references class(class_name),  
);
```

