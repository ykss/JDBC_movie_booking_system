<?php
#include('updateInfo.php')
include 'dbh.inc.php';
include "comment.inc.php";
#session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Profile</title>
  <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
  <div class="header">
  	<h2>Edit Profile</h2>
  </div>
  <form method="post" action="updateInfo.php">
  	<?php
    $id = $_SESSION['customer_id'];
    $result=mysqli_query($conn, "SELECT * FROM CustomerList WHERE customer_id='$id'");
    $row=mysqli_fetch_array($result);
    ?>
  	<div class="input">
  	  <label>Firstname</label>
  	  <input type="text" name="firstname" value='<?php echo $row['firstname']?>'>
  	</div>
    <div class="input">
  	  <label>Lastname</label>
  	  <input type="text" name="lastname" value='<?php echo $row['lastname']?>'>
  	</div>
    <div class="input">
  	  <label>Login ID</label>
  	  <input type="text" name="username" value='<?php echo $row['username']?>'>
  	</div>
  	<div class="input">
  	  <label>Email</label>
  	  <input type="email" name="email" value='<?php echo $row['email']?>'>
  	</div>

  	<div class="input">
  	  <button type="submit" class="btn" name="mypageEdit">Edit</button>
  	</div>
  </form>
</body>
</html>
