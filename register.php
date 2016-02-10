<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Register</title>
</head>  
<body>  
	<?php include "base.php"; ?>
	<?php include "functions.php"; ?>
	<?php include "header.php"; ?>
	<div class="container">
		<h3>Register a new account</h3>
		<form method="post">
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
					} else if (mysql_num_rows($check_email) == 1) {
						$message = "This email is already taken, please use a different email address.";
					} else {
						mysql_query("INSERT INTO users VALUES('', '".$email."', '".md5($password)."', '')");
						$message = "Successfully registered.";
					}
					echo "<div id='message'> $message </div>";
					echo "<script> 
						setTimeout(function(){
    						document.getElementById('message').style.display = 'none';
  						}, 3000);
					</script>";
				}
			?>
			Email Address : <br>
			<input type="text" name="email"/><br><br>
			Password : <br>
			<input type="password" name="password"/> <br><br>
			<input type="submit" name="submit" value="Register" />
		</form>
	</div>
</body>
</html>