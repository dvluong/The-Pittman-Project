<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <!-- Reference Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="google-signin-client_id" content="757099700822-29tejoue31hcm39hhbqm4p7qgqbkh06d.apps.googleusercontent.com">
<title>Register</title>
</head>  
<body class="body-background">  
	<?php include "main/base.php"; ?>
	<?php include "main/functions.php"; ?>
	<?php include "main/header.php"; ?>

	<div id="register-div">
		<div class="panel panel-default">
			<div class="panel-heading" style="background:black;">
				<h11><b>REGISTER</b></h11>
			</div>
			<br>
			<form method="post" autocomplete="nope">
				<?php 
				/* 
					Allows the user to create an account, if successful, a message will display.
				*/
				if (isset($_POST['submit'])) {
					$email = $_POST['email'];
					$password = $_POST['password'];
					$check_email = mysql_query("SELECT email FROM users WHERE email = '".$email."'");
					if (empty($email) or empty($password)) {
						$message = "Fields empty, re-check form.";
						echo "<div id='box' class='alert alert-warning' role='alert'> $message </div>";
					} else if (mysql_num_rows($check_email) == 1) {
						$message = "This email is already taken, please use a different email address.";
						echo "<div id='box' class='alert alert-danger' role='alert'> $message </div>";
					} else {
						mysql_query("INSERT INTO users VALUES('', '".$email."', '".md5($password)."', '')");
						$message = "Successfully registered.";
						echo "<div id='box' class='alert alert-success' role='alert'> $message </div>";
						header("location: index.php");
					}
					// echo "<script> 

					// 	setTimeout(function(){
    	// 					document.getElementById('box').style.display = 'none';
  			// 			}, 500);
					// </script>";
				}
				?>
				<p>Enter an email: <input type="text" name="email" value="" placeholder="Username or Email" autocomplete="nope"></p>
				<!-- Chrome has a stupid ass autofill 100% of the time, this input line stops that bullshit for some fucking reason -->
				<input type="password" name="password" id="password_fake" class="hidden" autocomplete="off" style="display: none;"> 
				<p>Enter a password: <input type="password" name="password" value="" placeholder="Password" autocomplete="nope"></p>
				
				<p class="submit"><input type="submit" name="submit" value="Register"></p>
			</form>
		</div>
	</div>
	<?php include "main/footer.php"; ?>
</body>
</html>