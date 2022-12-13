<?php
$con = mysqli_connect('localhost:3306', 'root', '1234','db-pj') or exit(mysqli_error());
if(!$con){
    echo "连接数据库失败";
}
else echo "连接数据库成功";
mysqli_query($con,"set names utf8");

$sql = "create Table IF NOT EXISTS student".
    "(ID INTEGER ,primary key (ID))";
$result = mysqli_query($con,$sql);
if(!$result){
    echo "失败";
}
else echo "成功";