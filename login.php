<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>User Management System (Tom Cameron for NetTuts)</title>
</head>  
<body>  
<div id="main">
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['firstname']))
{

     ?>
 
     <h1>Member Area</h1>
     <p>Thanks for logging in! You are <code><?=$_SESSION['firstname']?></code> and your email address is <code><?=$_SESSION['username']?></code>.</p>
     <a href="logout.php">Logout</a>
     <?php
     echo '<h2>Registered users:</h2>';
     ?>
     <?php
     $sql = "SELECT `firstname` 
           FROM `users_table` 
           ORDER BY `firstname` ASC";

     $result = mysql_query($sql);
     

    while($firstname = mysql_fetch_array($result)) {
        if ($firstname['firstname'] != $_SESSION['firstname']) {
            //echo $firstname['firstname']. '<br/>';
        ?>
            <div><code><?=$firstname['firstname']?></code> <a href="">Add to Group</a></div>
            <br>
            <?php
        }
    }
}
else if(!empty($_POST['username']) && !empty($_POST['password']))
{
    $username = mysql_real_escape_string($_POST['username']);
    $password = ($_POST['password']);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $checklogin = mysql_query("SELECT * FROM users_table WHERE email = '$username'");
     
    if(mysql_num_rows($checklogin) == 1 && password_verify($password, $hash))
    {
        $row = mysql_fetch_array($checklogin);
        $firstname = $row['firstname'];

        $_SESSION['username'] = $username;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['LoggedIn'] = 1;
         
        echo "<h1>Success</h1>";
        echo "<p>We are now redirecting you to the member area.</p>";
        echo "<meta http-equiv='refresh' content='2'; login.php' />";
    }
    else
    {
        echo "<h1>Error</h1>";
        echo "<p>Sorry, your account could not be found. Please <a href=\"login.php\">click here to try again</a>.</p>";
    }
}
else
{
    ?>
     
   <h1>Member Login</h1>
     
   <p>Thanks for visiting! Please either login below, or <a href="register.php">click here to register</a>.</p>
     
    <form method="post" action="login.php" name="loginform" id="loginform">
    <fieldset>
        <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
        <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
        <input type="submit" name="login" id="login" value="Login" />
    </fieldset>
    </form>
     
   <?php
}
?>
 
</div>
</body>
</html>