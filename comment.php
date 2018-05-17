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
  <style media="screen">

  </style>
  <link rel="stylesheet" type="text/css" href="com.css">
</head>
<body>

  <?php
  if(isset($_SESSION['customer_id'])){
    echo "<p style='background-color:rgba(255,255,255,0.8)' class='welcome'>You are logged in
    <span style='color:rgba(255,30,30,0.9)'>".$_SESSION['username']."</span></p>";
  }else{
    echo "Nobody is logged in";
  }
  ?>

  <?php
  echo "<form method='POST' action='".setComments($conn)."'>
  <input type='hidden' name='customer_id' value='".$_SESSION['customer_id']."'>
  <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
  <textarea name='message' class='text'></textarea><br/>
  <button type='submit' class='submitbox' name='submitcomment'>Comment</button>
  <br><br><br>
  </form>";

  getComments($conn);
  ?>


</body>
</html>
