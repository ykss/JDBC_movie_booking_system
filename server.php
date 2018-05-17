<?php
include 'dbh.inc.php';

session_start();

$errors = array();

if (isset($_POST['register'])) {
	register();
}

if (isset($_POST['login_user'])){
  login();
}

// REGISTER USER
function register(){

  global $conn, $errors;


	  // receive all input values from the form
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstname)) { array_push($errors, "Firstname is required"); }
  if (empty($lastname)) { array_push($errors, "Lastname is required"); }
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "Two passwords do not match");
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM customerlist WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    $password=$password_1;
  	// $password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO customerlist (firstname, lastname, username, password, email)
  			  VALUES('$firstname', '$lastname', '$username', '$password', '$email')";
    mysqli_query($conn, $query);

		header("Location: register.php?registerSuccess");
  }
}

function getIDofUser($id){
	global $conn;
	$query = "SELECT * FROM customerlist WHERE id=" . $id;
	$result = mysqli_query($conn, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

//login
function login(){

  global $conn, $errors;

  $username=mysqli_real_escape_string($conn, $_POST['username']);
  $password=mysqli_real_escape_string($conn, $_POST['password']);

  if(empty($username) || empty($password)){
    array_push($errors, "Fill username and password");
  }else{
    $sql = "SELECT * FROM customerlist WHERE username='$username'";
    $result=mysqli_query($conn, $sql);
    $resultCheck=mysqli_num_rows($result);
    if($resultCheck<1){
        array_push($errors, "Invalid username or password");
    }else{

			$row=mysqli_fetch_assoc($result);
      if($password!=$row['password']){
					array_push($errors, "Wrong password");
			}else{
				$_SESSION['customer_id']=$row['customer_id'];
				$_SESSION['username']=$row['username'];

				header("Location:comment.php?login=success");
				exit();
			}
    }
  }
}
