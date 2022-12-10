<?php
session_start();
$inputId = "";
$inputPassword = "";
if(isset($_POST["inputId"])){
    $inputId = $_POST["inputId"];
}
if(isset($_POST["inputPassword"])){
    $inputPassword = $_POST["inputPassword"];
}
if($inputId=="123"&&$inputPassword=="123"){
    $_SESSION["studentId"] = $inputId;
    echo "<script>window.location.href='/student';</script>";
}
else echo"<script>alert('fail');</script>";

