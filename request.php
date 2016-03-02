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
<title>Friend Requests</title>
</head>  
<body class="body-background">  
	<?php include "main/base.php"; ?>
	<?php include "main/functions.php"; ?>
	<?php include "main/header.php"; ?>
	
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
	<?php include "main/footer.php"; ?>
</body>
</html>