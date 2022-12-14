<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>添加学生信息</title>
</head>
<body>

<div>
  <form action="../../../Controllers/SuperAdminAddStudent.php" method="post">
    <div>student_id:<input type="text" name = "addstudent-student_id"></div>
    <div>name:<input type="text" name = "addstudent-name"></div>
    <div>phone_number:<input type="text" name = "addstudent-phone_number"></div>
    <div>email:<input type="text" name = "addstudent-email"></div>
    <div>dormitory:<input type="text" name = "addstudent-dormitory"></div>
    <div>living_address:<input type="text" name = "addstudent-living_address"></div>
    <div>idcard_type:<input type="text" name = "addstudent-idcard_type"></div>
    <div>idnumber:<input type="text" name = "addstudent-idnumber"></div>
    <div>
      <label>belong_campus_name</label>
      <select name = "addstudent-belong_campus_name">
        <option value="邯郸校区">邯郸校区</option>
        <option value="江湾校区">江湾校区</option>
        <option value="枫林校区">枫林校区</option>
        <option value="张江校区">张江校区</option>
      </select>
    </div>
    <div>
        <label>department_name:</label>
        <select name = "addstudent_department_name">
            <option value="信息科学与工程学院">信息科学与工程学院</option>
            <option value="基础医学院">基础医学院</option>
            <option value="大数据学院">大数据学院</option>
            <option value="微电子学院">微电子学院</option>
            <option value="新闻学院">新闻学院</option>
            <option value="法学院">法学院</option>
            <option value="管理学院">管理学院</option>
            <option value="经济学院">经济学院</option>
            <option value="计算机科学技术学院">计算机科学技术学院</option>
            <option value="软件学院">软件学院</option>
        </select>
    </div>
    <div>class_name:<input type="text" name = "addstudent-class_name"></div>
    <button type="submit">提交</button>
  </form>
</div>

</body>
</html>