<?php
include 'dbh.inc.php';

$schedule =  $_POST['schedule'];
//$date =  $_POST['date'];
//$screen_room_id =  $_POST['screen_room_id'];

echo "schedule: ".$schedule."<br>\n";
echo $_POST['numOfPeople']."<br>\n";

//$screenRoom = mb_substr($stringSchedule, -1, 0, 'utf-8');//끝점 
//$date = mb_substr($stringSchedule, 10, -8, 'utf-8');
//echo "screenRoom: ".$screenRoom."<br>\n";
//echo "date: ".$date."<br>\n";

//mb_substr("안녕하세요.", 0, 2, 'utf-8');
//곤지암 2018-05-17 12:00:00 2
/*
두번째 인수가 음수면 문자열 자르기의 시작점을 문자열의 끝부터 찾습니다.

세번째 인수가 음수면, 두번째 인수와 관계없이, (전체문자열길이 - 세번째인수)-1 가 자르기의 끝점.
*/

?>
<!DOCTYPE html>
<html>
<head>
<title>Reserve Seat</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
    <br>
<img src="seatInfo.JPG" width ="600" height="480"></td>
</body>
</html>
