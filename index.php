<?php
error_reporting(0);
$url = $_SERVER['REQUEST_URI'];
$urlAfter=parse_url($url);
$path=$urlAfter['path'];

$login = "";
if(isset($_GET["type"])){
    $login = $_GET["type"];
}
if($login == "login"){
    require 'Controllers/LoginController.php';
}

if($path == '/'){
    require 'Views/HTML/Login.html';
}

if($path == '/student'){
    require 'Views/HTML/Student/StudentMain.html';
}