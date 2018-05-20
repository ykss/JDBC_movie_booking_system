<?php
include_once "dbh.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Reservation</title>
  <link rel="stylesheet" type="text/css" href="com.css">
<body>
현재상영중인 영화정보 가져오기<br><br>

<form method="post" action="reserveSeat.php">
<select name='schedule'>
  <option value='' selected>-- 영화선택 --</option>
  <?php
  $rlt = $dbConnect->query(
"SELECT MovieInfoList.title, MovieScheduleList.schedule_id, MovieScheduleList.screen_room_id, MovieScheduleList.date 
FROM MovieInfoList JOIN MovieScheduleList USING (movie_id)"
);
while($schedule = mysqli_fetch_array($rlt)){
  $title = $schedule['title'];
  $date = $schedule['date'];
  $screen_room_id = $schedule['screen_room_id'];
  $option = $schedule['title'].'/ '.$schedule['date'].'/ '.$schedule['screen_room_id']."관";
?>
  <option value= '<?php echo $title.' '.$date.' '.$screen_room_id; ?>'> <?php echo $option;?></option>
 <?php }?>
  </select>

<br>

<p> 예매명수: <input type="text" name="numOfPeople" placeholder=" 예: 2"></p>
<button type="submit" class="btn" name="reserve">좌석 선택하기</button>
</form>
</body>
</html>

