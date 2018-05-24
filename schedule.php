<?php
include_once "dbh.inc.php";
?>

<html>
<head>
  <meta charset="utf-8">
  <title>Reservation</title>
  <link rel="stylesheet" type="text/css" href="com.css">
<body>
현재상영중인 영화정보 가져오기
<a href="index.php"><input type="button" value="메인페이지로" style="float: right;"></a>

<?php
echo"
<form method='post' action='".getSeats($conn)."'>
<select name='schedule'>
  <option value='' selected>-- 영화선택 --</option>";
$rlt = $conn->query(
"SELECT movieinfolist.title, movieschedulelist.schedule_id, movieschedulelist.screen_room_id, movieschedulelist.date
FROM movieinfolist JOIN movieschedulelist USING (movie_id)"
);
while($schedule = mysqli_fetch_array($rlt)){
  $schedule_id = $schedule['schedule_id'];
  if(strlen($schedule_id) == 1){
    $schedule_id = '00'.$schedule_id;
  }
  else if(strlen($schedule_id) == 2){
    $schedule_id = '0'.$schedule_id;
  }
  $title = $schedule['title'];
  $date = $schedule['date'];
  $screen_room_id = $schedule['screen_room_id'];
  $option = $schedule['title'].'/ '.$schedule['date'].'/ '.$schedule['screen_room_id'].'관';

  echo "<option value='". $schedule_id.' '.$title.' '.$date.' '.$screen_room_id."'>";
  echo $option;
  echo "</option>";
}
  echo "</select>";
  echo "<button type='submit' name='getSeat' style='width:70px; height:20px;'>좌석조회</button>";
  echo "</form>";

?>

 <?php
function getSeats($conn){
if(isset($_POST['getSeat'])){
  $schedule=$_POST['schedule'];
  echo "<br><br>";

  $schedule_id = substr($schedule, 0, 3);
  if(substr($schedule_id, 0, 2) == '00'){ //0의자리가 0, 10의 자리도 0
      $schedule_id = substr($schedule_id, 2, 1); //1의자리만 남기기
  }
  else if((substr($schedule_id, 0, 1) == '0') && (substr($schedule_id, 1, 1) !='0')) { //10의자리가 1~9, 100의 자리 0
      $schedule_id = substr($schedule_id, 1, 2);
  }

  $title = mb_substr($schedule, 4, -22, 'utf-8');
  $screenRoom = mb_substr($schedule, -1, 1, 'utf-8');
  $date = mb_substr($schedule, -21, -2, 'utf-8');
  echo "<p style='background-color:white; width:200px;'><strong>제목: </strong>".$title."</p>";
  echo "<p style='background-color:white; width:200px;'><strong>시간: </strong>".$date."</p>";
  echo "<p style='background-color:white; width:200px;'><strong>상영관: </strong>".$screenRoom."관</p>";
  echo "<br><br>";
  echo "이미 예약이 꽉찬 좌석들은: ";


  $result=mysqli_query($conn,"SELECT seat_id FROM seatlist WHERE schedule_id='$schedule_id'");
  while($row=mysqli_fetch_assoc($result)){
    echo "<span style='color:pink;'>".$row['seat_id']."/</span>";
  }
    echo "<br>이 좌석들 외의 좌석들을 예약해 주세요 <br><br>";

  echo"
  <form method='post' action='reserve.php'>";

  echo "<p> 예매명수: <input type='text' name='numOfPeople' placeholder=' 예: 2'></p>";
  echo "<p> 좌석선택: <input type='text' name='setSeat' placeholder=' 예: A01,A02'></p>";
  echo "<input type='hidden' name='schedule' value='".$_POST['schedule']."'>";

  echo "<img src='seatInfo.JPG' width ='600' height='480'>
  <button type='submit' class='button' name='reserve'>예매하기</button>
  </form>";
  exit();
}


}
  ?>
</body>
</html>
