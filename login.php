<?php
include('server.php')
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
  <div class="headtag">
  	<h2>Login</h2>
  </div>

  <form method="post" action="login.php">

    <?php  if (count($errorsfound) > 0){ ?>
      <div class="errors">
      	<?php foreach ($errorsfound as $i) : ?>
      	  <p><?php echo $i ?></p>
      	<?php endforeach ?>
      </div>
    <?php } ?>

  	<div class="input">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not registered? <a href="register.php">Create an account</a>
  	</p>
  </form>
</body>
</html>
