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
    $getAccess = "select * from access where student_id = '$student_id'";
    $studentAccess = $mysqli->query($getAccess);
    $rownum = mysqli_num_rows($studentAccess);
    if($rownum == 0){
        $studentAccess->free();
        $mysqli->close();
        echo "<script>alert('不存在这个学生！')</script>";
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
?>
</body>
</html>