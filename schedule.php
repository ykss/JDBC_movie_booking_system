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
<form method="post" action="reserve.php">
<select name='schedule'>
  <option value='' selected>-- 영화선택 --</option>
  <?php
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
  $option = $schedule['title'].'/ '.$schedule['date'].'/ '.$schedule['screen_room_id']."관";
?>
  <option value= '<?php echo $schedule_id.' '.$title.' '.$date.' '.$screen_room_id; ?>'> <?php echo $option;?> </option>
 <?php }?>
  </select>
<br>


<p> 예매명수: <input type="text" name="numOfPeople" placeholder=" 예: 2"></p>
<p> 좌석선택: <input type="text" name="setSeat" placeholder=" 예: A01,A02"></p>

</script>
<img src="seatInfo.JPG" width ="600" height="480"></td>
<button type="submit" class="btn" name="reserve">예매하기</button>
</form>
</body>
</html>
