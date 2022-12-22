<?php
function findDepart(){
    //链接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $getAllD="select * from department";
    $dataALL = $mysqli->query($getAllD);
    echo '<option value="NULL">全校</option>';
    while ($data = mysqli_fetch_assoc($dataALL)){
        echo '<option value="'.$data['department_name'].'">';
        echo  $data['department_name'];
        echo '</option>';
    }
    $mysqli->close();
}

function findClass(){
    //链接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $getAllD="select * from class where department_name = '".$_GET["depart"]."'";
    $dataALL = $mysqli->query($getAllD);
    echo '<option value="NULL">全系</option>';
    while ($data = mysqli_fetch_assoc($dataALL)){
        echo '<option value="'.$data['class_name'].'">';
        echo  $data['class_name'];
        echo '</option>';
    }
    $mysqli->close();
}