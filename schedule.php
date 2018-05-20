<?php
include_once "dbh.inc.php";
?>

<html>
<head>
  <meta charset="utf-8">
  <title>Reservation</title>
  <link rel="stylesheet" type="text/css" href="com.css">
<body>

<form method="post" action="reserve.php">

<select name='schedule'>
  <option value='' selected>-- 영화선택 --</option>
  <?php
  $rlt = $dbConnect->query(
"SELECT MovieInfoList.title, MovieScheduleList.schedule_id, MovieScheduleList.screen_room_id, MovieScheduleList.date 
FROM MovieInfoList JOIN MovieScheduleList USING (movie_id)"
);
while($schedule = mysqli_fetch_array($rlt)){
  $option = $schedule['title'].'/ '.$schedule['date'].'/ '.$schedule['screen_room_id']."관";
?>
  <option value= '<?php echo $option; ?>'> <?php echo $option;?></option>
  <?php }?>
</select>
<br>

<p> 예매명수: <input type="text" name="numOfPeople" placeholder=" 예: 4"></p>
<p> 좌석선택: <input type="text" name="seatInfo" placeholder=" 예: A0,A2"></p>
<button type="submit" class="btn" name="reserve">예매하기</button>
</form>
</body>
</html>

