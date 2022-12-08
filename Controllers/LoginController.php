<?php
$inputId = "";
$inputPassword = "";
if(isset($_POST["inputId"])){
    $inputId = $_POST["inputId"];
}
if(isset($_POST["inputPassword"])){
    $inputPassword = $_POST["inputPassword"];
}
if($inputId=="123"&&$inputPassword=="123"){
    echo "<script>window.location.href='/student';</script>";
}
else echo"<script>alert('fail');</script>";

