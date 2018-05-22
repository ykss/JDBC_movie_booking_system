<?php
include 'dbh.inc.php';

session_start();

$id = $_SESSION['customer_id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$username = $_POST['username'];

$query = "UPDATE CustomerList SET firstname='$firstname',lastname='$lastname',email='$email',username='$username' where customer_id='$id'";
$result=mysqli_query($conn, $query);
echo ("<meta http-equiv='Refresh' content='1, URL=mypage.php'>");
		#header("Location: mypageEdit.php?updateSuccess");
?>
