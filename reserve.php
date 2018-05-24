<?php
include_once "dbh.inc.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Reserve Seat</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
<a href="index.php"><input type="button" value="메인페이지로" style="float: right;"></a>

<?php
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
/*
echo "schedule: ".$schedule."<br>\n";
echo "schedule_id: ".$schedule_id."<br>\n";
echo "title: ".$title."<br>\n";
echo "date: ".$date."<br>\n";
echo "screenRoom: ".$screenRoom."<br>\n";
echo "numOfPeople: ".$numOfPeople."<br>\n";
echo "setSeat: ".$setSeat."<br>\n";
*/
$customer_id = $_SESSION['customer_id'];
//echo "customer_id: ".$customer_id."<br>\n";

$rlt = mysqli_fetch_array(mysqli_query($conn, "SELECT customer_type, customer_id FROM customerlist WHERE customer_id= '$customer_id'"));
$customer_type = $rlt['customer_type'];
$customer_id = $rlt['customer_id'];
//echo "customer_type: ".$customer_type."<br>\n";
//echo "customer_id: ".$customer_id."<br>\n";

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
//echo "price: ".$price."<br>\n";

//A01,A02,A03,E02
//0 4 8 12
for($i=0; $i<$numOfPeople; $i++){
    $seat_id = substr($setSeat, $i*4, 3);
   // echo "seat_id: ".$seat_id."<br>\n";
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
//echo "sql:".$sql."<br>\n";

if ($conn->query($sql) === TRUE){
   //echo "Insert successfully.$sql.<br>\n";
   $result = mysqli_fetch_array($conn->query("SELECT reserve_id FROM ReservationList
   WHERE customer_id='$customer_id' AND reserve_date='$date' AND schedule_id='$schedule_id' AND price='$price'"));
   $reserve_id = $result['reserve_id'];
   //echo "reserve_id: ".$reserve_id."<br>\n";

       for($i=0; $i<$numOfPeople; $i++){
    $seat_id = substr($setSeat, $i*4, 3);
    $sql="INSERT INTO seatlist (seat_id, schedule_id) VALUES ('$seat_id','$schedule_id')";

        if ($conn->query($sql) === TRUE){
           // echo "Insert successfully.$sql.<br>\n";
         } else {
            // echo "Insert Error: " . $sql . "<br>" . $conn->error."<br>\n";
         }

         $sql2 = "INSERT INTO ticketlist (reserve_id, seat_id) VALUES ('$reserve_id', '$seat_id')";
         //echo "SQL2: ".$sql2."<br>\n";
         if ($conn->query($sql2) === TRUE){
            //echo "Insert2 successfully.$sql2.<br>\n";
         } else {
            // echo "Insert2 Error: " . $sql2 . "<br>" . $conn->error."<br>\n";
         }
}
} else {
  //  echo "Insert Error: " . $sql . "<br>" . $conn->error."<br>\n";
}

$rlt = $conn->query("SELECT reserve_id FROM ReservationList WHERE customer_id='$customer_id'");
 $number=0;
 while($result = mysqli_fetch_array($rlt)){
 $number++;
 }
//echo "number: ".$number."<br>\n";

if($number >= 10){
  $query = "UPDATE CustomerList SET customer_type='VVIP' WHERE customer_id='$customer_id'";
}
else if($number >= 5){
  $query = "UPDATE CustomerList SET customer_type='VIP' WHERE customer_id='$customer_id'";
}

if ($conn->query($query) === TRUE){
  //  echo "Update successfully.$query.<br>\n";
 } else {
   //  echo "Update Error: " . $query . "<br>" . $conn->error."<br>\n";
 }

?>
<meta http-equiv='Refresh' content='0.3, URL=mypage.php'>
</body>
</html>
