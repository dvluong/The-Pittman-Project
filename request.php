<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Friend Requests</title>
</head>  
<body>  
	<?php include "base.php"; ?>
	<?php include "functions.php"; ?>
	<?php include "header.php"; ?>
	<div class="container">

		<h3>Group Requests: </h3> 
		<?php
			/*
				Displays all group requests made to this user.
			*/
			$my_id = $_SESSION['user_id']; 
			$group_query = mysql_query("SELECT from_user FROM group_request WHERE to_user='$my_id'");
			$groupFrom_query = mysql_query("SELECT id FROM group_request WHERE from_user='$user' AND to_user='$my_id'");
			while ($run_request = mysql_fetch_array($group_query)) {
				$from = $run_request['from_user'];
				$from_username = getUser($from, 'email');
				echo "<a href='profile.php?user=$from' class='box' style='display:block'>$from_username</a>";
			}
		?>
	</div>
</body>
</html>