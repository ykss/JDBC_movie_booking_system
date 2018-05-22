<?php
include 'dbh.inc.php';
session.start();

//$a = mb_strlen($schedule, 'utf-8')-2;
$schedule =  $_POST['schedule'];
$numOfPeople = $_POST['numOfPeople'];
$setSeat =  $_POST['setSeat'];

//자를 시작점, 자를 끝점 (음수면 뒤에서부터 count)
$schedule_id = substr($schedule, 0, 3);
if(substr($schedule_id, 0, 1) == 0 && substr($schedule_id, 1, 1)==0){ //0의자리가 0, 10의 자리도 0
    $schedule_id = substr($schedule_id, 2, 1); //1의자리만 남기기
}
else if(substr($schedule_id, 0, 1) == 0 && substr($schedule_id, 1, 1) !=0) { //10의자리가 1~9, 100의 자리 0
    $schedule_id = substr($schedule_id, 1, 2);
}
$title = mb_substr($schedule, 4, -22, 'utf-8');
$screenRoom = mb_substr($schedule, -1, 1, 'utf-8');
$date = mb_substr($schedule, -21, -2, 'utf-8');

echo "schedule: ".$schedule."<br>\n";
echo "schedule_id: ".$schedule_id."<br>\n";
echo "title: ".$title."<br>\n";
echo "date: ".$date."<br>\n";
echo "screenRoom: ".$screenRoom."<br>\n";
echo "numOfPeople: ".$numOfPeople."<br>\n";
echo "setSeat: ".$setSeat."<br>\n";


$user_id = $_SESSION['customer_id'];

$customer_type = mysqli_fetch_array(
    $conn->query("SELECT customer_type FROM customerlist WHERE customer_id='$user_id")
);
echo "customer_type".$customer_type."<br>/n";

/*
if($customer_type == "VVIP") {
    $price = ;
}
else if($customer_type == "VIP") {

}
else {

}
*/


$rlt = $conn->query(
"INSERT INTO reservationlist (customer_id, reserve_date, schedule_id, price)
VALUES ($user_id, $date, $schedule_id )"
);
while($schedule = mysqli_fetch_array($rlt)){
$title = $schedule['title'];
$date = $schedule['date'];
$screen_room_id = $schedule['screen_room_id'];
$option = $schedule['title'].'/ '.$schedule['date'].'/ '.$schedule['screen_room_id']."관";
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
</body>
</html>
