<?php 
	
	/*
		Logs the user out and destroys the current session.
	*/
	include "functions.php";
	session_destroy();
	header('location: index.php');
?>