<?php
$student_id = "";
$name = "";
$phone_number = "";
$email = "";
$dormitory = "";
$living_address = "";
$idcard_type = "";
$idnumber = "";
$belong_campus_name = "";
$class_name = "";
$department_name = "";
//获得post过来的数据
if(isset($_POST['addstudent-student_id'])){
    $student_id = $_POST['addstudent-student_id'];
}
if(isset($_POST['addstudent-name'])){
    $name = $_POST['addstudent-name'];
}
if(isset($_POST['addstudent-phone_number'])){
    $phone_number = $_POST['addstudent-phone_number'];
}
if(isset($_POST['addstudent-email'])){
    $email = $_POST['addstudent-email'];
}
if(isset($_POST['addstudent-dormitory'])){
    $dormitory = $_POST['addstudent-dormitory'];
}
if(isset($_POST['addstudent-living_address'])){
    $living_address = $_POST['addstudent-living_address'];
}
if(isset($_POST['addstudent-idcard_type'])){
    $idcard_type = $_POST['addstudent-idcard_type'];
}
if(isset($_POST['addstudent-idnumber'])){
    $idnumber = $_POST['addstudent-idnumber'];
}
if(isset($_POST['addstudent-belong_campus_name'])){
    $belong_campus_name = $_POST['addstudent-belong_campus_name'];
}
if(isset($_POST['addstudent-class_name'])){
    $class_name = $_POST['addstudent-class_name'];
}
if(isset($_POST['addstudent_department_name'])){
    $department_name = $_POST['addstudent_department_name'];
}
//对一些情况进行判断
$mysqli = mysqli_connect("localhost","root","1234","admission");
$findStudent = "select * from student where student_id = '$student_id'";
echo "<script>alert($findStudent)</script>";
echo $findStudent;
$findSameStudent = $mysqli->query($findStudent);
$rownum = mysqli_num_rows($findSameStudent);
if($rownum != 0){
    $findSameStudent->free();
    $mysqli->close();
    echo "<script>alert('数据库中已有相同id的学生！')</script>";
}
else{
    $insertStudent = "insert ignore into student (student_id,name,phone_number,email,dormitory,living_address,idcard_type,idnumber,belong_campus_name,department_name,class_name,password) values
    ('$student_id','$name','$phone_number','$email','$dormitory','$living_address','$idcard_type','$idnumber','$belong_campus_name','$department_name','$class_name','123456')";
    echo "$insertStudent";
    if(!$mysqli->query($insertStudent)){
        echo"<script>alert('数据插入失败！请重新初始化项目');</script>";
        $mysqli->close();
        exit;
    }
    else{
        echo "<script>alert('添加成功！');window.location.href = '/superadmin/addstudent'</script>";
    }
}