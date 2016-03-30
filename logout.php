<?php 
	
	/*
		Logs the user out and destroys the current session.
	*/
	include "main/functions.php";
	session_destroy();
	header('location: index.php');
?>