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
  if(isset($_SESSION['customer_id'])){
    echo "<p style='background-color:rgba(255,255,255,0.8)' class='welcome'>You are logged in
    <span style='color:rgba(255,30,30,0.9)'>".$_SESSION['username']."</span></p>";
  }else{
    echo "Nobody is logged in";
  }

  if(isset($_POST['lookinfo'])){
    $movie_id=$_POST['movie_id'];
    $_SESSION['movie_id']=$movie_id;

    $sql="SELECT poster_img FROM movieinfolist WHERE movie_id='$movie_id'";
    $result=mysqli_query($conn,$sql);
    $List=mysqli_fetch_assoc($result);
    echo "
    <div class='comm_box'><img src='".$List['poster_img']."' class='pic'>
    </div>";
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

  echo "<div class='order'>Order by: ";
  echo "<form method='POST' action='".orderBy($conn)."'>
  <input type='hidden' name='customer_id' value='".$_SESSION['customer_id']."'>
  <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' class='btn' name='orderRev'>Avg Review</button>
    <button type='submit' class='btn 'name='orderRecent'>Most Recent</button></form></div>";

  getComments($conn);
  ?>


</body>
</html>
