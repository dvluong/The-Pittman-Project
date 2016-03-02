<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
	<meta charset="UTF-8" />
    <title>Cyberfed</title>
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
	<title>Index</title>
</head>  
<body class="body-background"> 
	Teh Home Page. 
	<?php include "main/base.php"; ?>
	<?php include "main/functions.php"; ?>
	<?php include "main/header.php"; ?>
	<?php
		/*
			This is the main page with the important php files included. I also implemented
			a method where it checks if the current user is in a group. If the user is in a group,
			and there are extra requests, delete those requests. The extra requests made by the admin
			are a little different. Basically it checks if the admin's group is full, if it is, delete
			all extra requests made by the admin.
		*/
		$my_id = $_SESSION['user_id']; 
		$check_if_admin = mysql_query("SELECT admin FROM groups WHERE admin='$my_id'");
		if (mysql_num_rows($check_if_admin) == 1) {
			$get_from_request = mysql_query("SELECT from_user FROM group_request WHERE from_user='$my_id'");
			$check_if_full = mysql_query("SELECT user_five FROM groups WHERE $admin='$my_id' AND is_full='full'");
			if (mysql_num_rows($check_if_full) == 1) {
				while ($run = mysql_fetch_array($get_from_request)) {
					$delete_requests = $run['from_user'];
					mysql_query("DELETE FROM group_request WHERE from_user='$my_id'");
				}
			}
		} 

		/*
			What this block of code does is the following: if you are in a group and you have any extra
			requests from other users, loop through the database and find all rows matching to your id. 
			Delete everything that matches with your id. This is mainly for a user who is not an admin.
		*/
		$if_in_group = mysql_query("SELECT id, in_group FROM users WHERE id='$my_id' AND in_group='1'");
		$check_requests = mysql_query("SELECT to_user FROM group_request WHERE to_user='$my_id'");
		if (mysql_num_rows($if_in_group) == 1 && mysql_num_rows($check_requests) == 1) {
			while ($run = mysql_fetch_array($check_requests)) {
					$to_requests = $run['to_user'];
					mysql_query("DELETE FROM group_request WHERE to_user='$to_requests'");
			}
		}

	?>
	<?php include "main/footer.php"; ?>
</body>
</html>