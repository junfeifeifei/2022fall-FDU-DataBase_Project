<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>查看老师及管理员信息</title>
    <link rel="stylesheet" type="text/css" href="../../Views/CSS/SuperAdmin/SuperAdminStudentInfo.css">
</head>
<body>

<table style="border: 1px solid">
    <tr>
        <td>student_id</td>
        <td>name</td>
        <td>authority</td>
    </tr>
    <?php
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    $getAllUser = "select * from teacher";
    $allUser = $mysqli->query($getAllUser);
    $rownum=mysqli_num_rows($allUser);
    for($i=0;$i<$rownum;$i++){
        $rows=mysqli_fetch_assoc($allUser);
        $teacher_id = $rows['teacher_id'];
        $name = $rows['name'];
        $authority = $rows['authority'];
        echo
        "<div>
            <tr>
                <td>$teacher_id</td>
                <td>$name</td>
                <td>$authority</td>
            </tr>
        </div>";
    }
    ?>
</table>


</body>
</html>