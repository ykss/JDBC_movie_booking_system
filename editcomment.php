<?php
  date_default_timezone_set("Asia/Seoul");
  include 'dbh.inc.php';
  include 'comment.inc.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Comments</title>
  <link rel="stylesheet" type="text/css" href="comment.css">
</head>
<body>

  <?php
  $comment_id=$_POST['customer_id'];
  $uid=$_POST['comment_id'];
  $date=$_POST['date'];
  $message=$_POST['message'];

  echo "<form method='POST' action='".editComments($conn)."'>
  <input type='hidden' name='customer_id' value='".$comment_id."'>
  <input type='hidden' name='comment_id' value='".$uid."'>
  <input type='hidden' name='date' value='".$date."'>
  <textarea name='message' row='8' column='80'>".$message."</textarea><br/>
  <button type='submit' name='submit'>Comment</button>
  </form>"
  ?>





</body>
</html>
