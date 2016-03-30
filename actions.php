<?php 
	include 'main/base.php';
	include 'main/functions.php';
	/* 
		As the name suggests, 'action' will get the user's action.
		For example, if the user accepts a group request, that would
		be the 'acceptGroup' action.
	*/
	$action = $_GET['action'];

	/*
		The $user variable gets the user id according to the profile page.
		So if the profile page is on the second user in the database, the
		user id in the url would have a number '2'.
	*/
	$user = $_GET['user'];
	$my_id = $_SESSION['user_id'];


	/*
		An action that sends a group request to another user.
	*/
	if ($action == 'send') {
		//mysql_query("INSERT INTO friend_request VALUES ('', '$my_id', '$user')");
		mysql_query("INSERT INTO group_request VALUES ('', '$my_id', '$user')");
		header('location: profile.php?user='.$user);
	}

	/*
		An action that cancels a group request sent to another user.
	*/
	if ($action == 'cancel') {
		//mysql_query("DELETE FROM friend_request WHERE from_user='$my_id' AND to_user='$user'");
		mysql_query("DELETE FROM group_request WHERE from_user='$my_id' AND to_user='$user'");
		header('location: profile.php?user='.$user);
	}

	/*
		An action that accepts a group request from another user. At the moment,
		the group database has a fixed number of members allowed in the group, so 
		only 5 members are allowed in one group including the person who created the group.
		So basically, the admin is allowed to add 4 more members to the group he created. These
		if statements are making sure that certain slots aren't full so the user can be put in the 
		appropriate slot. For example, if user_two already has a member in it, it will move onto user_three
		to see if there is an empty slot, if there is, it will add the user to user_three. At the same time,
		it will also update a column in the users database. All users will start out with '0' in the in_group
		column. If a user is added to a group and then accepts the request, then the in_group column for that 
		user that accepts the group request will be changed from '0' to '1', signafying that the user is in a group.
		Doing this will ensure that user cannot be added to another group, since at the moment, users can only be in
		one group. Also, at the beginning of the action, it will delete the group request since the user is accepting
		the request.
	*/
	if ($action == 'acceptGroup') {
		mysql_query("DELETE FROM group_request WHERE from_user='$user' AND to_user=$my_id");
		// do we want only the admin inviting members or everyone in the group can invites
		$user_two = mysql_query("SELECT user_two FROM groups WHERE admin='$user' AND user_two='0'");
		$user_three = mysql_query("SELECT user_three FROM groups WHERE admin='$user' AND user_three='0'");
		$user_four = mysql_query("SELECT user_four FROM groups WHERE admin='$user' AND user_four='0'");
		$user_five = mysql_query("SELECT user_five FROM groups WHERE admin='$user' AND user_five='0'");
		//echo mysql_num_rows($user_four);
		if (mysql_num_rows($user_two) == 1) {
			mysql_query("UPDATE groups SET user_two='$my_id' WHERE admin='$user'");
			mysql_query("UPDATE users SET in_group='1' WHERE id='$my_id'");
			echo header("location: groups.php");
		} else if (mysql_num_rows($user_three) == 1) {
			mysql_query("UPDATE groups SET user_three='$my_id' WHERE admin='$user'");
			mysql_query("UPDATE users SET in_group='1' WHERE id='$my_id'");
			echo header("location: groups.php");
		} else if (mysql_num_rows($user_four) == 1) {
			mysql_query("UPDATE groups SET user_four='$my_id' WHERE admin='$user'");
			mysql_query("UPDATE users SET in_group='1' WHERE id='$my_id'");
			echo header("location: groups.php");
		} else if (mysql_num_rows($user_five) == 1) {
			mysql_query("UPDATE groups SET user_five='$my_id' WHERE admin='$user'");
			mysql_query("UPDATE groups SET is_full='full' WHERE admin='$user'");
			mysql_query("UPDATE users SET in_group='1' WHERE id='$my_id'");
			echo header("location: groups.php");
		} 
	}

	/*
		An action that deletes the entire group. This action is only available to the admin, which is
		the user that created the group. Before the deletetion of the group, the users database will first be
		updated. The column in_group will change from '1' to '0' for all members that are in that group. After
		the update, the group will be deleted from the database.
	*/
	if ($action == 'deleteGroup') {

		/* 
			Gets the id of user 2, 3, 4, and 5 according to the admin's id. Doing this will ensure that
			only the admin is allowed to delete the group.
		*/
		// I am using the same variable names so it is clear to any user looking at this code
		// if there is a bug, change the variable names
		$user_two = mysql_fetch_array(mysql_query("SELECT user_two FROM groups WHERE admin='$my_id'"));
		$user_three = mysql_fetch_array(mysql_query("SELECT user_three FROM groups WHERE admin='$my_id'"));
		$user_four = mysql_fetch_array(mysql_query("SELECT user_four FROM groups WHERE admin='$my_id'"));
		$user_five = mysql_fetch_array(mysql_query("SELECT user_five FROM groups WHERE admin=$my_id"));

		/*
			After getting the users id by fetching the array from the database, in order to access it,
			we need to get the actual value of the id since the fetch array method only returns an array,
			so if you specify the name correctly, you will be able to have access to the value of the array.
		*/
		$string_two = $user_two['user_two'];
		$string_three = $user_three['user_three'];
		$string_four = $user_four['user_four'];
		$string_five = $user_five['user_five'];

		mysql_query("UPDATE users SET in_group='0' WHERE id='$my_id'");
		mysql_query("UPDATE users SET in_group='0' WHERE id='$string_two'");
		mysql_query("UPDATE users SET in_group='0' WHERE id='$string_three'");
		mysql_query("UPDATE users SET in_group='0' WHERE id='$string_four'");
		mysql_query("UPDATE users SET in_group='0' WHERE id='$string_five'");	
		mysql_query("DELETE FROM groups WHERE admin='$my_id'");	
		header('location: groups.php');
	}


	/*
		An action that removes a member from the group. Only the admin is allowed to do this
		and after being removed from the group, the user will be updated to not being in a group
		anymore. 
	*/
	if ($action == 'removeGroup') {

		/*
			Ensures the user is the admin.
		*/
		$admin_user = mysql_query("SELECT admin FROM groups WHERE admin='$my_id'");
		if (mysql_num_rows($admin_user) == 1) {

			/*
				Checks if the user that is about to be deleted is the correct match.
			*/
			$user_2 = mysql_query("SELECT user_two FROM groups WHERE admin='$my_id' AND user_two='$user'");
			$user_3 = mysql_query("SELECT user_three FROM groups WHERE admin='$my_id' AND user_three='$user'");
			$user_4 = mysql_query("SELECT user_four FROM groups WHERE admin='$my_id' AND user_four='$user'");
			$user_5 = mysql_query("SELECT user_five FROM groups WHERE admin='$my_id' AND user_five='$user'");

			/*
				Checks to see if the slot in groups database is empty.
			*/		
			$check_empty_2 = mysql_query("SELECT user_two FROM groups WHERE admin='$my_id' AND user_two='0'");
			$check_empty_3 = mysql_query("SELECT user_three FROM groups WHERE admin='$my_id' AND user_three='0'");
			$check_empty_4 = mysql_query("SELECT user_four FROM groups WHERE admin='$my_id' AND user_four='0'");
			$check_empty_5 = mysql_query("SELECT user_five FROM groups WHERE admin='$my_id' AND user_five='0'");

			/*
				The next few if statements will check to make sure the user being deleted is that specific user.
				The if statements inside the if statements are used to shift the data in the database. For example,
				if you deleted user_two from the groups table, and if there exists a user_three, then the data from user_three
				will shift over to user_two, etc, etc.
			*/

			if (mysql_num_rows($user_2) == 1) {
				mysql_query("UPDATE groups SET user_two='0' WHERE user_two='$user'");
				mysql_query("UPDATE users SET in_group='0' WHERE id='$user'");
				/*
					If user_two is deleted, shift all other values left once.
				*/
				if (mysql_num_rows($check_empty_3) != 1) {
					$string_3 = mysql_fetch_array(mysql_query("SELECT user_three FROM groups WHERE admin='$my_id'"))['user_three'];
					$string_4 = mysql_fetch_array(mysql_query("SELECT user_four FROM groups WHERE admin='$my_id'"))['user_four'];
					$string_5 =	mysql_fetch_array(mysql_query("SELECT user_five FROM groups WHERE admin='$my_id'"))['user_five'];

					mysql_query("UPDATE groups SET user_two='$string_3', user_three='$string_4', user_four='$string_5', user_five='0'");
					mysql_query("UPDATE groups SET is_full='full' WHERE admin='$my_id'");
				}

				echo header("location: groups.php");
			} else if (mysql_num_rows($user_3) == 1) {
				mysql_query("UPDATE groups SET user_three='0' WHERE user_three='$user'");
				mysql_query("UPDATE users SET in_group='0' WHERE id='$user'");

				if (mysql_num_rows($check_empty_4) != 1) {
					/*
						If user_three is deleted, shift all other values left once.
					*/
					$string_4 = mysql_fetch_array(mysql_query("SELECT user_four FROM groups WHERE admin='$my_id'"))['user_four'];
					$string_5 =	mysql_fetch_array(mysql_query("SELECT user_five FROM groups WHERE admin='$my_id'"))['user_five'];

					mysql_query("UPDATE groups SET user_three='$string_4', user_four='$string_5', user_five='0'");
					mysql_query("UPDATE groups SET is_full='full' WHERE admin='$my_id'");
				}

				echo header("location: groups.php");
			} else if (mysql_num_rows($user_4) == 1) {
				mysql_query("UPDATE groups SET user_four='0' WHERE user_four='$user'");
				mysql_query("UPDATE users SET in_group='0' WHERE id='$my_id'");

				if (mysql_num_rows($check_empty_5) != 1) {
					/*
						If user_four is deleted, shift all other values left once.
					*/
					$string_5 =	mysql_fetch_array(mysql_query("SELECT user_five FROM groups WHERE admin='$my_id'"))['user_five'];

					mysql_query("UPDATE groups SET user_four='$string_5', user_five='0'");
					mysql_query("UPDATE groups SET is_full='full' WHERE admin='$my_id'");
				}
				echo header("location: groups.php");
			} else if (mysql_num_rows($user_5) == 1) {
				mysql_query("UPDATE groups SET user_five='0' WHERE user_five='$user'");
				mysql_query("UPDATE groups SET is_full='full' WHERE admin='$user'");
				mysql_query("UPDATE users SET in_group='0' WHERE id='$my_id'");
				echo header("location: groups.php");
			}
		}
	}
?>