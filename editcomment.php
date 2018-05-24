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
  <link rel="stylesheet" type="text/css" href="com.css">
</head>
<body>

  <?php
  $comment_id=$_POST['comment_id'];
  $customer_id=$_POST['customer_id'];
  $message=$_POST['message'];

  echo "<form method='POST' action='".editComments($conn)."'>
  <input type='hidden' name='comment_id' value='".$comment_id."'>
  <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
  <textarea name='message' style='width:300px; height:200px;'>".$message."</textarea><br/>
  <button type='submit' style='width:300px;height:30px;' name='editcomment'>Comment</button>
  </form>";

  ?>


</body>
</html>
