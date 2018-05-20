<?php
/*
    $host = "localhost";
    $user = "root";
    $pw ="961220";
    $dbName ="DB Team Project";
    $dbConnect=new mysqli($host, $user, $pw, $dbName);
    $dbConnect->set_charset("utf8");
    $dbh=new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8",$user,$pw);

    if(mysqli_connect_errno()){
         echo "<script>console.log('" . $dbName . "DB 접속 실패: " . mysqli_connect_error() . "' );</script>";
    }
    else{
         echo "<script>console.log('" . $dbName . " DB 접속 성공');</script>";
    }
    */
$dbServername ="localhost";
$dbUsername ="root";
$dbPassword ="961220";
$dbName ="DB Team Project";

// connect to the database
$conn=mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

if(!$conn){
  die("Connection failed: ".mysqli_connect_error());
}

?>