<?php

	session_start();

	/*
		Returns true if the user is logged in.
	*/
	function loggedIn() {
		if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
			return true;
		} else {
			return false;
		}
	}

	/*
		Get's the users id from the user table in the database.
	*/
	function getUser($id, $field) {
		$query = mysql_query("SELECT $field FROM users WHERE id='$id'");
		$run = mysql_fetch_array($query);
		return $run[$field];
	}

?>