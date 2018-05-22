<?php
include_once "dbh.inc.php";
//session.start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Reserve Seat</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
<?php
//$a = mb_strlen($schedule, 'utf-8')-2;
$schedule =  $_POST['schedule'];
$numOfPeople = $_POST['numOfPeople'];
$setSeat =  $_POST['setSeat'];


//자를 시작점, 자를 끝점 (음수면 뒤에서부터 count)
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

echo "schedule: ".$schedule."<br>\n";
echo "schedule_id: ".$schedule_id."<br>\n";
echo "title: ".$title."<br>\n";
echo "date: ".$date."<br>\n";
echo "screenRoom: ".$screenRoom."<br>\n";
echo "numOfPeople: ".$numOfPeople."<br>\n";
echo "setSeat: ".$setSeat."<br>\n";

//$user_id = $_SESSION['customer_id'];

$user_id = 'sj15';
$rlt = mysqli_fetch_array(mysqli_query($conn, "SELECT customer_type, customer_id FROM customerlist WHERE username= '$user_id'"));
$customer_type = $rlt['customer_type'];
$customer_id = $rlt['customer_id'];
echo "customer_type: ".$customer_type."<br>\n";
echo "customer_id: ".$customer_id."<br>\n";

$price=0;
if($customer_type == "VVIP") {
    $price = $numOfPeople*10000*0.7;
}
else if($customer_type == "VIP") {
    $price = $numOfPeople*10000*0.85;
}
else {
    $price = $numOfPeople*10000;
}
echo "price: ".$price."<br>\n";

//A01,A02,A03,E02
//0 4 8 12
for($i=0; $i<$numOfPeople; $i++){
    $seat_id = substr($setSeat, $i*4, 3);
    echo "seat_id: ".$seat_id."<br>\n";
    $rlt = $conn->query("SELECT seat_id FROM seatlist WHERE schedule_id = '$schedule_id'");
    while($seat = mysqli_fetch_array($rlt)){
        if($seat['seat_id'] == $seat_id){
            //insert error
            echo "<script>alert('이미 예약된 좌석을 선택하셨습니다. 예매페이지로 돌아갑니다.')</script>";
            header("Refresh:0; url='schedule.php'");
        }
    }
}
$sql = "INSERT INTO reservationlist (customer_id, reserve_date, schedule_id, price) VALUES ('$customer_id', '$date', '$schedule_id','$price')";
echo "sql:".$sql."<br>\n";

if ($conn->query($sql) === TRUE){
   echo "Insert successfully<br>\n";
} else {
    echo "Insert Error: " . $sql . "<br>" . $conn->error."<br>\n";
}

$rlt = mysqli_query($conn, "SELECT reserve_id FROM ReservationList WHERE reserve_id='$id'");
$number = 0;
while($res = mysqli_fetch_array($rlt)){
  $number++;
}
if($number >= 10){
  $query = "UPDATE CustomerList SET customer_type='VIP' WHERE customer_id='$id'";
}
else if($number >= 5){
  $query = "UPDATE CustomerList SET customer_type='VVIP' WHERE customer_id='$id'";
}

for($i=0; $i<$numOfPeople; $i++){
    $seat_id = substr($setSeat, $i*4, 3);
    $sql="INSERT INTO seatlist (seat_id, schedule_id) VALUES ('$seat_id','$schedule_id')";
        if ($conn->query($sql) === TRUE){
            echo "Insert successfully<br>\n";
         } else {
             echo "Insert Error: " . $sql . "<br>" . $conn->error."<br>\n";
         }
}

$triggerSql = 
"CREATE TRIGGER When_Insert_reservationlist AFTER INSERT ON reservationlist 
FOR EACH ROW
BEGIN 
INSERT INTO ticketlist (seat_id, reserve_id, schedule_id) VALUES ('$seat_id', NOW(), '$schedule_id');
END";

/*
$triggerSql = "CREATE TRIGGER Insert_ticketlist AFTER INSERT ON ticketlist 
FOR EACH ROW
BEGIN 
INSERT INTO reservationlist (customer_id, reserve_date, schedule_id, price) VALUES ('$customer_id', '$date', '$schedule_id','$price');
END";
*/
if ($conn->query($triggerSql) === TRUE) {
    echo "Trigger successfully<br>\n";
} else {
    echo "Trigger Error: " . $sql . "<br>" . $conn->error."<br>\n";
}

/*
$rlt = mysqli_fetch_array(mysqli_query($conn, 
"SELECT reserve_id FROM reservationlist WHERE customer_id= '$customer_id' AND reserve_date ='$date' AND schedule_id='$schedule_id' AND price = '$price'"));
$reserve_id = $rlt['reserve_id'];
echo "reserve_id: ".$reserve_id."<br>\n";
*/



?>

</body>
</html>