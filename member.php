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
<title>Members</title>
</head>  
<body class="body-background">  
	<?php include "main/base.php"; ?>
	<?php include "main/functions.php"; ?>
	<?php include "main/header.php"; ?>
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
				echo "<a href='profile.php?user=$user_id' class='boxes' style='display: block;'>$user</a>";
			}
		?>
	</div>
	<?php include "main/footer.php"; ?>
</body>
</html>