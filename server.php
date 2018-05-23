<?php
include 'dbh.inc.php';

session_start();

$errorsfound = array();

$view=mysqli_query($conn,"CREATE VIEW customer AS SELECT customerlist.username, customerlist.customer_id, likelist.comment_id FROM customerlist JOIN likelist ON customerlist.customer_id=likelist.customer_id");
$viewtwo=mysqli_query($conn,"CREATE VIEW cuscomlike AS SELECT customer.username, customer.comment_id, customer.customer_id, commentlist.movie_id, commentlist.starpoint, commentlist.date, commentlist.message FROM customer JOIN commentlist ON customer.comment_id=commentlist.comment_id");
$viewthree=mysqli_query($conn,"CREATE VIEW countlikenum AS SELECT COUNT(customer_id) AS counter, comment_id FROM cuscomlike GROUP BY comment_id ORDER BY counter DESC");

$totalseat = mysqli_query($conn, "CREATE VIEW totalseat AS SELECT movie_id,COUNT(movie_id) AS NumOfSchedule, 40*COUNT(movie_id) AS totalseat FROM `movieschedulelist` GROUP BY movie_id");
$reservedseat = mysqli_query($conn, "CREATE VIEW reservedseat AS SELECT movie_id,SUM(sl.count) AS reservedseatnum from movieschedulelist NATURAL JOIN (SELECT schedule_id,COUNT(schedule_id) AS count FROM seatlist GROUP BY schedule_id)sl WHERE schedule_id = sl.schedule_id GROUP BY movie_id");
$reservedrate = mysqli_query($conn, "CREATE VIEW reservedrate AS SELECT SELECT reservedseat.movie_id, totalseat, reservedseatnum, reservedseatnum / totalseat * 100 AS reserved_rate FROM reservedseat, totalseat WHERE totalseat.movie_id = reservedseat.movie_id");

if (isset($_POST['register'])) {
	register();
}

if (isset($_POST['login_user'])){
  login();
}

//Register
function register(){

  global $conn, $errorsfound;


	//receive from form
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);


	//Check if empty
  if (empty($firstname)) { array_push($errorsfound, "Firstname is required"); }
  if (empty($lastname)) { array_push($errorsfound, "Lastname is required"); }
  if (empty($username)) { array_push($errorsfound, "Username is required"); }
  if (empty($email)) { array_push($errorsfound, "Email is required"); }
  if (empty($password_1)) { array_push($errorsfound, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errorsfound, "Two passwords do not match");
  }

	//check if there are same username or email
  $user_check_query = "SELECT * FROM customerlist WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errorsfound, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errorsfound, "email already exists");
    }
  }

	//If no error register
	if (count($errorsfound) == 0) {
    $password=$password_1;

  	$query = "INSERT INTO customerlist (firstname, lastname, username, password, email)
  			  VALUES('$firstname', '$lastname', '$username', '$password', '$email')";
    mysqli_query($conn, $query);

		header("Location: register.php?registerSuccess");
  }
}

//login
function login(){

  global $conn, $errorsfound;

  $username=mysqli_real_escape_string($conn, $_POST['username']);
  $password=mysqli_real_escape_string($conn, $_POST['password']);

  if(empty($username) || empty($password)){
    array_push($errorsfound, "Fill username and password");
  }else{
    $sql = "SELECT * FROM customerlist WHERE username='$username'";
    $result=mysqli_query($conn, $sql);
    $resultCheck=mysqli_num_rows($result);
    if($resultCheck<1){
        array_push($errorsfound, "Invalid username or password");
    }else{

			$row=mysqli_fetch_assoc($result);
      if($password!=$row['password']){
					array_push($errorsfound, "Wrong password");
			}else{
				$_SESSION['customer_id']=$row['customer_id'];
				$_SESSION['username']=$row['username'];

				header("Location:index.php?login=success");
				exit();
			}
    }
  }
}
