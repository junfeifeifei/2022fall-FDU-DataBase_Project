<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>查看入校权限</title>
</head>
<body>
<form method="post">
    <div>请输入学生的id：<input type="text" name = "studentaccess-student_id"></div>
    <button type="submit">查询入校权限</button>
</form>

<?php
$student_id = "";
if(isset($_POST["studentaccess-student_id"])){
    $student_id = $_POST["studentaccess-student_id"];
    $mysqli = mysqli_connect("localhost","root","1234","admission");

    $teacher_id = $_SESSION['teacher_id'];
    $sql = "select class_name,department_name from class where counselor_id = '$teacher_id'";
    $sqlQuery = $mysqli->query($sql);
    $rowcount = mysqli_num_rows($sqlQuery);
    for($i = 0;$i<$rowcount;$i++){
        $rows = mysqli_fetch_assoc($sqlQuery);
        $class = $rows['class_name'];
        $department = $rows['department_name'];
    }
    $sql2 = "select * from student where class_name = '$class' and department_name = '$department' and student_id = '$student_id'";
    $sqlQuery2 = $mysqli->query($sql2);
    $rowcount2 = mysqli_num_rows($sqlQuery2);

    if($rowcount2 == 0){
        echo "<script>alert('没有对这个学生的查看权限！')</script>";
    }
    else{
        $getAccess = "select * from access where student_id = '$student_id'";
        $studentAccess = $mysqli->query($getAccess);
        $rownum = mysqli_num_rows($studentAccess);
        if($rownum == 0){
            $studentAccess->free();
            $mysqli->close();
            echo "<script>alert('不存在这个学生的记录！')</script>";
        }
        else{
            for($i = 0;$i < $rownum;$i++){
                $rows=mysqli_fetch_assoc($studentAccess);
                $campus_name = $rows['campus_name'];
                $state = $rows['state'];
                if($state == 1){
                    $access = "有权限";
                }
                else{
                    $access = "无权限";
                }
                echo "<div>$campus_name:$access</div>";
            }
        }
    }

}
?>
</body>
</html>