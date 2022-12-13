<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>查看学生信息</title>
    <link rel="stylesheet" type="text/css" href="../../Views/CSS/SuperAdmin/SuperAdminStudentInfo.css">
</head>
<body>

<table style="border: 1px solid">
    <tr>
        <td>student_id</td>
        <td>name</td>
        <td>phone_number</td>
        <td>email</td>
        <td>dormitory</td>
        <td>living_address</td>
        <td>idcard_type</td>
        <td>idnumber</td>
        <td>belong_campus_name</td>
        <td>class_name</td>
        <td>department_name</td>
    </tr>
<?php
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    $getAllUser = "select * from student";
    $allUser = $mysqli->query($getAllUser);
    $rownum=mysqli_num_rows($allUser);
    for($i=0;$i<$rownum;$i++){
        $rows=mysqli_fetch_assoc($allUser);
        $student_id = $rows['student_id'];
        $name = $rows['name'];
        $phone_number = $rows['phone_number'];
        $email = $rows['email'];
        $dormitory = $rows['dormitory'];
        $living_address = $rows['living_address'];
        $idcard_type = $rows['idcard_type'];
        $idnumber = $rows['idnumber'];
        $belong_campus_name = $rows['belong_campus_name'];
        $class_name = $rows['class_name'];
        $department_name = $rows['department_name'];
        echo
        "<div>
            <tr>
                <td>$student_id</td>
                <td>$name</td>
                <td>$phone_number</td>
                <td>$email</td>
                <td>$dormitory</td>
                <td>$living_address</td>
                <td>$idcard_type</td>
                <td>$idnumber</td>
                <td>$belong_campus_name</td>
                <td>$class_name</td>
                <td>$department_name</td>
            </tr>
        </div>";
    }
?>
</table>


</body>
</html>