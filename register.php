<?php
include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
  <div class="headtag">
  	<h2>Register</h2>
  </div>

  <form method="post" action="register.php">

    <?php  if (count($errorsfound) > 0){ ?>
      <div class="errors">
      	<?php foreach ($errorsfound as $i) : ?>
      	  <p><?php echo $i ?></p>
      	<?php endforeach ?>
      </div>
    <?php } ?>

  	<div class="input">
  	  <label>Firstname</label>
  	  <input type="text" name="firstname">
  	</div>
    <div class="input">
  	  <label>Lastname</label>
  	  <input type="text" name="lastname">
  	</div>
    <div class="input">
  	  <label>Login ID</label>
  	  <input type="text" name="username">
  	</div>
  	<div class="input">
  	  <label>Email</label>
  	  <input type="email" name="email">
  	</div>
  	<div class="input">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input">
  	  <button type="submit" class="btn" name="register">Register</button>
  	</div>
  	<p>
  		Already have an account? <a href="login.php">Log in</a>
  	</p>
  </form>
</body>
</html>
