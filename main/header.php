<nav id="nav-color" class="navbar">
	<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span style="background-color:#fff" class="icon-bar"></span>
			<span style="background-color:#fff" class="icon-bar"></span>
			<span style="background-color:#fff" class="icon-bar"></span>
		</button>
			<a class="navbar-brand" href="index.php"><img src="images/cycfed.jpg"></a>
	</div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li><a class="nav-item" href="index.php">Home</a></li>
			<li class="dropdown">
				<a href="#" class="nav-item dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cyberfed Show <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a class="nav-item" href="https://www.youtube.com/channel/UCqru5uPONxySBARWAmONQcg">Full Episodes</a><li>
					<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="https://www.youtube.com/playlist?list=PLfSy00ugfQQwvfFEMFf_B5yGwdNPf3tuq">Inside the Game</a></li>
					<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="https://www.youtube.com/playlist?list=PLfSy00ugfQQzem5diPNvFzkoAfJQVsqx0">UJWC</a></li>
					<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="https://www.youtube.com/playlist?list=PLfSy00ugfQQzaHMBXyhsB_SR_u6wv7tjD">Edicts by Edith</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="nav-item dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Competition <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a class="nav-item" href="#">Find Competitions</a><li>
					<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="#">Register Competitions</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="nav-item dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">News <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a class="nav-item" href="#">Press</a><li>
					<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="#">Competition news</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="nav-item dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a class="nav-item" href="#">Press</a><li>
					<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="#">Competition news</a></li>
				</ul>
			</li>
			<li><a class="nav-item" href="#">Contact us</a></li>
		<?php 
		/*
			Contains all the links to the php files.
		*/
		if (loggedIn()) {
		?>
			
				<li class="dropdown">
					<a href="#" class="nav-item dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Member Area <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a class="nav-item" href="profile.php">Profile</a></li>	
          				<li role="separator" class="divider"></li>
						<li><a class="nav-item" href="request.php">Requests</a></li>
						<li role="separator" class="divider"></li>
						<li><a class="nav-item" href="member.php">Members</a></li>
						<li role="separator" class="divider"></li>
						<li><a class="nav-item" href="groups.php">Groups</a></li>
						<li role="separator" class="divider"></li>
						<li><a class="nav-item" href="logout.php">Log Out</a></li>
					</ul>
				</li>
			</ul>
			<!-- <li class="dropdown">
          		<a href="#" class="dropdown-toggle nav-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          		<ul class="dropdown-menu">
          			<li><a class="nav-item" href="profile.php">Profile</a></li>	
          			<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="request.php">Requests</a></li>
					<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="member.php">Members</a></li>
					<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="groups.php">Groups</a></li>
					<li role="separator" class="divider"></li>
					<li><a class="nav-item" href="logout.php">Log Out</a></li>
          		</ul> -->
         	<ul class="nav navbar-nav navbar-right">
         		<li>
			<?php 
				$my_id = $_SESSION['user_id'];
				$email = mysql_fetch_array(mysql_query("SELECT email FROM users WHERE id='$my_id'"))['email'];
				echo "<a class='nav-item' href='profile.php'>Logged in as: $email</a>";
			?>
				</li>
			</ul>
		<?php
		} else {
		?>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="nav-item dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a>
				<ul id="login-dp" class="dropdown-menu">
				<li>
					<div class="row">
							<div class="col-md-12">
								Login via
								<form method="post">
									<?php 
									/*
										A simple login page, checks to see if the user exists in the database, if it does, redirect
										the user to the index page. If not, error message.
									*/
									if (isset($_POST['submit'])) {
										$email = $_POST['email'];
										$password = $_POST['password'];


										if (empty($email) or empty($password)) {
											$message = "Fields empty, re-check form.";
										} else {
											$check_login = mysql_query("SELECT id FROM users WHERE email='$email' AND password='".md5($password)."'");
											if (mysql_num_rows($check_login) == 1) {
												$get = mysql_fetch_array($check_login);
												$user_id = $get['id'];
												$_SESSION['user_id'] = $user_id;


												header('location: index.php');

												exit();
											} else {
												$message = "Incorrect email or password.";
											}
										}
										echo "<div id='box' class='alert alert-danger' role='alert'> $message </div>";
										echo "<script> 
											alert($message);
											setTimeout(function(){
					    						document.getElementById('box').style.display = 'none';
					  						}, 3000);
										</script>";
									}
									?>
									<p><input type="text" name="email" value="" placeholder="Username or Email"></p>
									<!-- Chrome has a stupid ass autofill 100% of the time, this input line stops that bullshit for some fucking reason -->
									<input type="password" name="password" id="password_fake" class="hidden" autocomplete="off" style="display: none;"> 
									<p><input type="password" name="password" value="" placeholder="Password"></p>
									<p class="submit"><input type="submit" name="submit" value="Login"></p>			
								</form>
							</div>
							<div class="bottom text-center">
								New here ? <a href="register.php"><b>Join Us</b></a>
							</div>
						</div>
				</li>
			</ul>
		</ul>
		<?php
		}
		?>
		<!-- <div class="clear"></div> -->
	   </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>