<?php
	session_start();
	session_destroy();
	$_SESSION = array();
?>
<meta content="0; login.php" http-equiv="refresh">