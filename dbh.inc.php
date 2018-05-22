<?php

$dbServername ="localhost";
$dbUsername ="root";
$dbPassword ="000000";
$dbName ="ressystem";

// connect to the database
$conn=mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

if(!$conn){
  die("Connection failed: ".mysqli_connect_error());
}
