<?php
include_once "dbh.inc.php";
include "comment.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Mypage</title>
</head>
<style>
  body {
    background-image: url(moviepost.png);
  }
  h1 {
    background-color: rgba(255,255,255,0.7);
    text-align: center;
  }
  #info {
    background-color: rgba(255,255,255,0.7);
    text-align: center;
  }
</style>
<body>

  <?php
  if(isset($_SESSION['customer_id'])){
    echo "<p style='background-color:rgba(255,255,255,0.8)' class='welcome'>You are logged in
    <span style='color:rgba(255,30,30,0.9)'>".$_SESSION['username']."</span></p>";
  }else{
    echo "Nobody is logged in";
  }
  ?>
  <h1>My Page</h1>
  <?php
  $currentId = $_SESSION['customer_id'];

  $rlt = mysqli_query($conn,"SELECT * FROM CustomerList WHERE customer_id=$currentId");
  $List = mysqli_fetch_assoc($rlt);
    ?>
    <div id='info'>
      <hr>
      <p>First Name: <?php echo $List['firstname']?></p><hr>
      <p>Last Name: <?php echo $List['lastname']?></p><hr>
      <p>Email: <?php echo $List['email']?></p><hr>
      <p>User Name: <?php echo $List['username']?></p><hr>
      <p>Type: <?php echo $List['customer_type']?></p>
      <hr>
    </div>
    <?php  echo "<center><button class='button' name='editInfo'>
      개인정보수정</button></center>
    </form>";
    ?>
    <center><h3>Reservation List</h3></center>
    <?php
      $rlt = mysqli_query($conn,"SELECT reserve_date, title, date FROM ReservationList JOIN MovieScheduleList
                              ON ReservationList.customer_id=$currentId AND ReservationList.schedule_id = MovieScheduleList.schedule_id
                              JOIN MovieInfoList ON MovieScheduleList.movie_id = MovieInfoList.movie_id");
      $List = mysqli_fetch_array($rlt); ?>
      <div id='info'>
        <?php
      echo "예약일시: ";
      echo $List['reserve_date'];
      echo "<br>";
      echo "영화제목: ";
      echo $List['title'];
      echo "<br>";
      echo "상영일시: ";
      echo $List['date'];
      echo "<br>";
     ?>

    </div>
</body>
</html>
