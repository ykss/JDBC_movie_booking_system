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
  movieDisplay($conn);
  ?>


  <?php
  echo "<form method='POST' action='".setComments($conn)."'>
  <input type='hidden' name='customer_id' value='".$_SESSION['customer_id']."'>
  <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'><br><br>
  <div style='font-size:30px; width:100%; margin-left:40%;'>Rating:
  <input type='number' class='starpoint'  max='10' name='starpoint' style='width:10%; height:30px;'></div>
  <textarea name='message' class='text'></textarea><br/>
  <button type='submit' class='submitbox' name='submitcomment'>Comment</button>
  <br><br><br>
  </form>";

  echo "<div class='avg'>Average Starpoint: </div>";
  $movie_id=$_SESSION['movie_id'];
  $sql="SELECT AVG(starpoint) AS avg FROM commentlist WHERE movie_id='$movie_id'";
  $result=mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  echo "<div class='avg'>".$row['avg']."/10.0</div>";


  echo "<div class='order'>Order by: ";
  echo "<form method='POST' action='".orderBy($conn)."'>
  <input type='hidden' name='customer_id' value='".$_SESSION['customer_id']."'>
  <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' class='btn' name='orderLike'>Most Likes</button>
    <button type='submit' class='btn 'name='orderRecent'>Most Recent</button></form></div>";


 getComments($conn);
  ?>


</body>
</html>
