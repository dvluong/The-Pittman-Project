<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Login</title>
</head>  
<body>  
	<?php include "base.php"; ?>
	<?php include "functions.php"; ?>
	<?php include "header.php"; ?>
	<div class="container">
		<h3>Login into your account</h3>
		<form method="post">
			<?php 
				/*
					A simple login page, checks to see if the user exists in the database, if it does, redirect
					the user to the index page. If not, error message.
				*/
				if (isset($_POST['submit'])) {
					$email = $_POST['email'];
					$password = $_POST['password'];


					if (empty($email) or empty($password)) {
						$message = "Fields empty, re-check form.";
					} else {
						$check_login = mysql_query("SELECT id FROM users WHERE email='$email' AND password='".md5($password)."'");
						if (mysql_num_rows($check_login) == 1) {
							$get = mysql_fetch_array($check_login);
							$user_id = $get['id'];
							$_SESSION['user_id'] = $user_id;


							header('location: index.php');

							exit();
						} else {
							$message = "Incorrect email or password.";
						}
					}
					echo "<div class='box'> $message </div>";
				}
			?>
			Email Address : <br>
			<input type="text" name="email"/><br><br>
			Password : <br>
			<input type="password" name="password"/> <br><br>
			<input type="submit" name="submit" value="Login" />
		</form>
	</div>
</body>
</html>