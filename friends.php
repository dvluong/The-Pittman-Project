<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Friends</title>
</head>  
<body>  
	<?php include "base.php"; ?>
	<?php include "functions.php"; ?>
	<?php include "header.php"; ?>
	<div class="container">
		<h3>Friends:</h3>
		<?php 

			/*
				
			*/
			$my_id = $_SESSION['user_id']; 
			$friend_query = mysql_query("SELECT user_one, user_two FROM friends WHERE user_one='$my_id' OR user_two='$my_id'");
			while ($run_friend = mysql_fetch_array($friend_query)) {
				$user_one = $run_friend['user_one'];
				$user_two = $run_friend['user_two'];
				if ($user_one == $my_id) {
					$user = $user_two;
				} else {
					$user = $user_one;
				}
				$username = getUser($user, 'email');
				echo "<a href='profile.php?user=$user' class='box' style='display:block'> $username</a>";
			}
		?>
	</div>
</body>
</html>