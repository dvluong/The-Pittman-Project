<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Group</title>
</head>  
<body>  
	<?php include "base.php"; ?>
	<?php include "functions.php"; ?>
	<?php include "header.php"; ?>
	<div class="container">
		<h3>Group:</h3>
		<?php

			/*
				Gets the session id of the user.
			*/
			if (isset($_GET['user']) && !empty($_GET['user'])) {
				$user = $_GET['user'];
			} else {
				$user = $_SESSION['user_id'];
			}

			/*
				Gets the current session id of the user.
			*/
			$my_id = $_SESSION['user_id']; 
			$if_in_group = mysql_query("SELECT id, in_group FROM users WHERE id='$my_id' AND in_group='1'");
			if (mysql_num_rows($if_in_group) == 1) {

				/* 
					Delete any extra requests this user may have. Basically if the user accepts a group invitation
					but has other group invitations, these requests will be deleted automatically.
				*/
				$check_to_requests = mysql_query("SELECT to_user FROM group_request WHERE to_user='$my_id'");
				if (mysql_num_rows($if_in_group) == 1) {
					while ($run = mysql_fetch_array($check_to_requests)) {
						$to_requests = $run['to_user'];
						mysql_query("DELETE FROM group_request WHERE to_user='$to_requests'");
		
					}
				}

				/* 
					Delete all extra group reqests made by this admin. If the admin made multiple group requests, which
					will happen since you can create a group with up to 5 members, then once the group is full, the 
					remaining requests will be deleted automatically. 
				*/

				$admin_requests = mysql_fetch_array(mysql_query("SELECT admin FROM groups WHERE user_two='$my_id' OR user_three='$my_id' OR user_four='$my_id' OR user_five='$my_id'"));
				$admin_str = $admin_requests['admin']; // to get the admin id
				$get_from_request = mysql_query("SELECT from_user FROM group_request WHERE from_user='$admin_str'");
				$check_if_full = mysql_query("SELECT user_five FROM groups WHERE admin='$admin_str' AND is_full='full'");
				if (mysql_num_rows($check_if_full) == 1) {
					while ($run = mysql_fetch_array($get_from_request)) {
						$delete_requests = $run['from_user'];
						mysql_query("DELETE FROM group_request WHERE from_user='$delete_requests'");
					}
				} 

				/*
					If you are the admin, the function to delete the group will be made available.
				*/
				$admin_id = mysql_query("SELECT group_name FROM groups WHERE admin='$my_id'");
				$show_group = mysql_fetch_array($admin_id); 	
				if (mysql_num_rows($admin_id) == 1) {
					$name = $show_group['group_name'];	
					echo "<h4>$name</h4>";
					echo "<a href='actions.php?action=deleteGroup&user=$user' class='box'>Delete Group</a>";
				}
				
				/*
					If you are a regular member, only the name of the group will show up.
				*/
				$group_id = mysql_query("SELECT group_name FROM groups WHERE user_two='$my_id' OR user_three='$my_id' OR user_four='$my_id' OR user_five='$my_id'");
				if ($admin_id != 1) {
					$show_name = mysql_fetch_array($group_id);
					if (mysql_num_rows($group_id) == 1) {
						$nameForMember = $show_name['group_name'];
						echo "<h4>$nameForMember</h4>";
					}
				}

				/* 
					If the admin is the current session id, this displays all group members in the admin's
					group.
				*/
				if (mysql_num_rows($admin_id) == 1) {
					$user_admin_str = mysql_fetch_array(mysql_query("SELECT admin FROM groups WHERE admin='$my_id'"));
					$user_2_str = mysql_fetch_array(mysql_query("SELECT user_two FROM groups WHERE admin='$my_id'"));
					$user_3_str = mysql_fetch_array(mysql_query("SELECT user_three FROM groups WHERE admin='$my_id'"));
					$user_4_str = mysql_fetch_array(mysql_query("SELECT user_four FROM groups WHERE admin='$my_id'"));
					$user_5_str = mysql_fetch_array(mysql_query("SELECT user_five FROM groups WHERE admin='$my_id'"));
					
					$user_admin = getUser($user_admin_str['admin'], 'email');
					$user_two = getUser($user_2_str['user_two'], 'email');
					$user_three = getUser($user_3_str['user_three'], 'email');
					$user_four = getUser($user_4_str['user_four'], 'email');
					$user_five = getUser($user_5_str['user_five'], 'email');

					$number_1 = $user_admin_str['admin'];
					$number_2 = $user_2_str['user_two'];
					$number_3 = $user_3_str['user_three'];
					$number_4 = $user_4_str['user_four'];
					$number_5 = $user_5_str['user_five'];

					echo "<a href='profile.php?user=$number_1' class='box' style='display: block;'>$user_admin</a>";
					if ($user_2_str['user_two'] != 0) {
						echo "<a href='profile.php?user=$number_2' class='box' style='display: block;'>$user_two</a>";
						if ($user_3_str['user_three'] != 0) {
							echo "<a href='profile.php?user=$number_3' class='box' style='display: block;'>$user_three</a>";
							if ($user_4_str['user_four'] != 0) {
								echo "<a href='profile.php?user=$number_4' class='box' style='display: block;'>$user_four</a>";
								if ($user_5_str['user_five'] != 0) {
									echo "<a href='profile.php?user=$number_5' class='box' style='display: block;'>$user_five</a>";
								}
							}
						}
					}
					
				}

				/* 
					This is for a regular member's view. Basically, if the admin isn't the current session id, then it is a
					little difficult to display the whole grouop to a regular member. I worked around this by checking to see
					if the group name matches the one in the database. Else you would have to compare the current session id to
					user_two, three, four, and five. Obviously this would suck ass.
				*/
				if (mysql_num_rows($group_id) == 1) {
					$user_admin_str = mysql_fetch_array(mysql_query("SELECT admin FROM groups WHERE group_name='$nameForMember'"));
					$user_2_str = mysql_fetch_array(mysql_query("SELECT user_two FROM groups WHERE group_name='$nameForMember'"));
					$user_3_str = mysql_fetch_array(mysql_query("SELECT user_three FROM groups WHERE group_name='$nameForMember'"));
					$user_4_str = mysql_fetch_array(mysql_query("SELECT user_four FROM groups WHERE group_name='$nameForMember'"));
					$user_5_str = mysql_fetch_array(mysql_query("SELECT user_five FROM groups WHERE group_name='$nameForMember'"));

					$user_admin = getUser($user_admin_str['admin'], 'email');
					$user_two = getUser($user_2_str['user_two'], 'email');
					$user_three = getUser($user_3_str['user_three'], 'email');
					$user_four = getUser($user_4_str['user_four'], 'email');
					$user_five = getUser($user_5_str['user_five'], 'email');

					$number_1 = $user_admin_str['admin'];
					$number_2 = $user_2_str['user_two'];
					$number_3 = $user_3_str['user_three'];
					$number_4 = $user_4_str['user_four'];
					$number_5 = $user_5_str['user_five'];

					echo "<a href='profile.php?user=$number_1' class='box' style='display: block;'>$user_admin</a>";
					if ($user_2_str['user_two'] != 0) {
						echo "<a href='profile.php?user=$number_2' class='box' style='display: block;'>$user_two</a>";
						if ($user_3_str['user_three'] != 0) {
							echo "<a href='profile.php?user=$number_3' class='box' style='display: block;'>$user_three</a>";
							if ($user_4_str['user_four'] != 0) {
								echo "<a href='profile.php?user=$number_4' class='box' style='display: block;'>$user_four</a>";
								if ($user_5_str['user_five'] != 0) {
									echo "<a href='profile.php?user=$number_5' class='box' style='display: block;'>$user_five</a>";
								}
							}
						}
					}
				}
			} 

		?>
		<form method="post">
			<?php
				/*
					Get current session id. Allows user to create a group if not in a group and updates
					the user table.
				*/
				$my_id = $_SESSION['user_id']; 
				if (isset($_POST['submit'])) {
					$group_name = $_POST['group_name'];
					$check_group_name = mysql_query("SELECT group_name FROM groups WHERE group_name = '".$group_name."'");
					if (empty($group_name)) {
						$message = "Fields empty, re-check form.";
					} else if (mysql_num_rows($check_group_name) == 1) {
						$message = "This group_name is already taken, please use a different name.";
					} else {
						mysql_query("INSERT INTO groups(id, group_name, admin, user_two, user_three, user_four, user_five) VALUES('', '".$group_name."', '".$my_id."', '0', '0', '0', '0')");
						mysql_query("UPDATE users SET in_group='1' WHERE id='$my_id'");

						header('location: groups.php');

						exit();
					}
					echo "<div class='box'> $message </div>";
				}
			?> 
			<?php

				/*
					If you're not in a group, you're allowed to create one.
				*/
				$check_group = mysql_query("SELECT id FROM users WHERE id='$my_id' AND in_group='0'");

				if (mysql_num_rows($check_group) == 1) {
					echo "Enter group name : <br>";
					echo '<input type="text" name="group_name"/><br><br>';
			
					echo '<input type="submit" name="submit" value="Create Group" />';
				}
			?>
		</form>
	</div>
</body>
</html>