<div id="title-bar">
	<ul>
		<li><a href="index.php">Home</a></li>
		<?php 
		/*
			Contains all the links to the php files.
		*/
		if (loggedIn()) {
		?>
			<li><a href="profile.php">Profile</a></li>	
			<li><a href="request.php">Requests</a></li>
			<li><a href="member.php">Members</a></li>
			<li><a href="groups.php">Groups</a></li>
			<li><a href="logout2.php">Log Out</a></li>
			<?php 
				$my_id = $_SESSION['user_id'];
				$email = mysql_fetch_array(mysql_query("SELECT email FROM users WHERE id='$my_id'"))['email'];
				echo "<li style='float: right'>Logged in as:<a href='profile.php'>$email</a></li>"
			?>
		<?php
		} else {
		?>
			<li><a href="login2.php">Login</a></li>
			<li><a href="register2.php">Register</a></li>
		<?php
		}
		?>
		<div class="clear"></div>
	</ul>
</div>