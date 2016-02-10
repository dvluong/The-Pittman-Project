<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Members</title>
</head>  
<body>  
	<?php include "base.php"; ?>
	<?php include "functions.php"; ?>
	<?php include "header.php"; ?>
	<div class="container">
		<h3>Members</h3>
		<?php 
			/*
				Displays all registered users in a list format.
			*/
			$member_query = mysql_query("SELECT id FROM users");
			while ($run_mem = mysql_fetch_array($member_query)) {
				$user_id = $run_mem['id'];
				$user = getUser($user_id, 'email');
				echo "<a href='profile.php?user=$user_id' class='box' style='display: block;'>$user</a>";
			}
		?>
	</div>
</body>
</html>