<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Profile</title>
</head>  
<body>  
	<?php include "base.php"; ?>
	<?php include "functions.php"; ?>
	<?php include "header.php"; ?>
	<div class="container">
		<?php 

			/*
				Display the user's username. Will not display 'actions' if you are on your profile.
			*/
			if (isset($_GET['user']) && !empty($_GET['user'])) {
				$user = $_GET['user'];
			} else {
				$user = $_SESSION['user_id'];
			}
			$my_id = $_SESSION['user_id'];
			$username = getUser($user, 'email');
		?>
		<h3> 
			<?php 
				echo "<h2> Email: </h2>";
				echo $username; 
			?> 
		</h3>

		<?php 
			$get_group = mysql_fetch_array(mysql_query("SELECT group_name FROM groups WHERE admin='$my_id' OR user_two='$my_id' OR user_three='$my_id' OR user_four='$my_id' OR user_five='$my_id'"))['group_name']; 
			if ($user == $my_id) {
				echo "<h2>Your group: </h2>";
				echo "<a href='groups.php'>$get_group</a>";
			}
			/*
				Allows the admin to add, remove users if the current session id is the admin. Also allows the admin
				to cancel existing requests. If the admin is trying to add another user to his/her group, the if statements
				will check to see if that user is already in a group, if that user is, it will display a message instead of
				an action button. A message will also display if you are not in a group.
			*/
			if ($user != $my_id) {
				
				$check_group = mysql_query("SELECT id FROM users WHERE id='$my_id' AND in_group='1'"); // checks if current user is in a group
				$check_user = mysql_query("SELECT id FROM users WHERE id=$user AND in_group='0'"); // checks if the current profile is the user
				/*
					Ran into a very weird bug where it allowed the admin of another group to remove users from another group.
					I suspect the reason for this is the $check_in_group variable. As you can see from the SQL statement, it is 
					quite long with a lot of OR's and this could be the reason for the bug. So I decided to separate it into 4 different
					SQL statements and this fixed the issue although it did make the first if check very big.
				*/
				$user_two = mysql_query("SELECT id, admin FROM groups WHERE admin='$my_id' AND user_two='$user'");
				$user_three = mysql_query("SELECT id, admin FROM groups WHERE admin='$my_id' AND user_three='$user'");
				$user_four = mysql_query("SELECT id, admin FROM groups WHERE admin='$my_id' AND user_four='$user'");
				$user_five = mysql_query("SELECT id, admin FROM groups WHERE admin='$my_id' AND user_five='$user'");

				//$check_in_group = mysql_query("SELECT id, admin FROM groups WHERE admin='$my_id' AND user_two='$user' OR user_three='$user' OR user_four='$user' OR user_five='$user'");

				$check_if_full = mysql_query("SELECT admin FROM groups WHERE admin='$my_id' AND user_five='0'"); // check if the group is full
				$check_if_admin = mysql_query("SELECT admin FROM groups WHERE admin='$my_id'");	// check if the current user logged in is an admin of a group

				if (mysql_num_rows($check_group) == 1 && mysql_num_rows($check_if_admin) == 1 && (mysql_num_rows($user_two) == 1 || mysql_num_rows($user_three) == 1 || mysql_num_rows($user_four) == 1 || mysql_num_rows($user_five) == 1)) {
				 	echo "<a href='actions.php?action=removeGroup&user=$user' class='box'>Remove from Group</a>";
				} else {
					$groupFrom_query = mysql_query("SELECT id FROM group_request WHERE from_user='$user' AND to_user='$my_id'");
					$groupTo_query = mysql_query("SELECT id FROM group_request WHERE from_user='$my_id' AND to_user='$user'");
					if (mysql_num_rows($groupFrom_query) == 1) {
						echo "<a href='actions.php?action=acceptGroup&user=$user' class='box'>Accept Group</a>";
					} else if (mysql_num_rows($groupTo_query) == 1) {
						echo "<a href='actions.php?action=cancel&user=$user' class='box'> Cancel </a>";
					} else if (mysql_num_rows($check_if_admin) == 1 && mysql_num_rows($check_if_full) == 1 && mysql_num_rows($check_user) == 1){
						echo "<a href='actions.php?action=send&user=$user' class='box'>Add to Group</a>";
					} else if (mysql_num_rows($check_if_admin) != 1 && mysql_num_rows($check_group) == 1) {
						$not_admin = "You are in a group but you are not an admin, so you cannot add/remove this person.";
						echo "<div class='box'> $not_admin </div>";
					} else if (mysql_num_rows($check_group) == 1 && mysql_num_rows($check_if_full) == 1 && mysql_num_rows($check_if_admin) == 1) {
						$user_in_group = 'This member is already in a group.';
						echo "<div class='box'> $user_in_group </div>";
					} else if (mysql_num_rows($check_if_full) != 1 && mysql_num_rows($check_if_admin) == 1) {
						$message = 'Your group is full, you cannot add any more members.';
						echo "<div class='box'> $message </div>";
					} else if (mysql_num_rows($check_group) != 1) {
						$message = "You're not in a group, please join or create a group.";
						echo "<div class='box'> $message </div>";
					}
				}
			}
		?>
	</div>
</body>
</html>