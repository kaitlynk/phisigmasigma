<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="style.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Phi Sigma Sigma</title>
<script type="text/javascript" src="https://use.typekit.com/ahu5nxd.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="phisigsig.js"></script>
</head>
<body>
	<?php
		if (!isset($_SESSION['logged_user'])) {
			$_SESSION['logged_user'] = $_POST['username'];
		}
	?>

	<div class="center">
		<div class="ribbon">
			<ul>
				<a href="index.php"><li class="logo">ΦΣΣ</li></a>
				<a href="dashboard.php"><li>HOME</li></a>
				<a href="history.php"><li>HISTORY</li></a>
				<a href='events.php'><li>EVENTS</li></a>
				<a href='blog.php'><li>BLOGS</li></a>
				<a href="photos.php"><li>PHOTOS</li></a>
				<a href="contact.php"><li>CONTACT</li></a>
			</ul>
			<div class="user">
				Welcome, <?php 
					$con = mysql_connect("localhost","root","kkk524425kk");
					
					if (!$con) {
                        die('Could not connect: '. mysql_error());
                   	}
                   	
               		mysql_select_db("test_Final_Project", $con);
               		$un = $_SESSION['logged_user'];
               		$admin = mysql_query("SELECT isAdmin FROM users WHERE username='".$un."'");
               		if (mysql_result($admin, 0) == 1) {
						echo "<a href = admin.php><div class='user'><u>".$un."</u>!</div>";
					}
					else {
						echo "notadmin".$un."!";
					}
					?>
				<br>
				<div class='user'><a class="logout" href="logout.php">Logout</a></div>
			</div>		
		</div>
		<h1 id="ribbon_bottom" class="ribbon">
			<strong class="ribbon-content">Phi Sigma Sigma</strong>
		</h1>
		<div class='module'>
			<h2>
				Admin Dashboard
			</h2>
		<!-- Add Blogpost
			If POST[blogcontent], POST[title] is set
				Get currdate
				Insert into blogposts values(id, POST[title], POST[blogcontent], currdate, currdate) 
				Insert into notifications values(currdate, actionid, blog) -->
		<!-- Edit Blogpost
			Connect to final proj database
			Select title from blogposts
			Display titles with checkboxes
			[Submit form will take to another php page with text fields with auto-filled title and content]
			Connect to final proj database
			Select currdate from blogposts where blogchange=title
			Get currdate
			Update users set title=new title, content=new content, oldcurrdate, currdate) -->
				
		<!-- Add Event
			If POST[name], POST[date] is set
				Insert into blogposts values(id, POST[name], POST[date])
				Get currdate
				Insert into notifications values(currdate, actionid, event) -->
	
		<div id="newuser">
			<h3>
				Add User
			</h3>
			<h5>
				<table>
					<form name='adduser' action='admin.php' method='post'>
					<tr>
						<td>Username: 
						<td><input type='text' name='newuser'/>
					</tr>
					<tr>
						<td>Password: 
						<td><input type='password' name='newpw'/>
					</tr>
					<tr>
						<td align='right'><input type='checkbox' name='isadmin' value='isadmin'/> 
						<td>Administrator <br>
					</tr>
					<tr>
						<td>
						<td align='right'><input type='submit' name='submit' value='Create' onclick='adduser();'>
					</tr>
					</form>
				</table>
			</h5>
			<?php
				if (isset($_POST['newuser']) && isset($_POST['newpw'])) {
					$con = mysql_connect("localhost","root","kkk524425kk");
					
					if (!$con) {
                        die('Could not connect: '. mysql_error());
                   	}
                   	
               		mysql_select_db("test_Final_Project", $con);
               		$newuser = $_POST['newuser'];
               		$newpw = $_POST['newpw'];
               		$users = mysql_query('SELECT username FROM users');
               		$numusers = mysql_num_rows($users);
               		$alreadyexists = false;
               		for ($j = 0; $j < $numusers - 1; $j++) {
						$user = mysql_result($users, $j);
						if (strcasecmp($newuser, $user)) {
							$alreadyexists = true;
						}
					}
					if ($alreadyexists) {
						echo "<h5>The username \"".$newuser."\" already exists. Please enter a different name.</h5><br>";
					}
               		else if ($_POST['isadmin'] == isadmin) {
                    	mysql_query('INSERT INTO users VALUES(\''.$newuser.'\', \''.$newpw.'\', 1)');
                    	echo "<h5>Added administrator ".$newuser." to the site.</h5>";
                    }
                    else {
                    	mysql_query('INSERT INTO users VALUES(\''.$newuser.'\', \''.$newpw.'\', 0)');
                        echo "<h5>Added user ".$newuser." to the site.</h5>";
                    }
             	}
            ?>
            
            <button onclick="users()">Users</button>
            <div id = 'allusers'>
            	<form name='removeuser' action='admin.php' method='post'>
            	<?php
            		$con = mysql_connect("localhost","root","kkk524425kk");
					
					if (!$con) {
                        die('Could not connect: '. mysql_error());
                   	}
                   	
               		mysql_select_db("test_Final_Project", $con);
               		$users = mysql_query('SELECT username FROM users');
               		$numusers = mysql_num_rows($users);
               		for ($j = 0; $j < $numusers - 1; $j++) {
						$user = mysql_result($users, $j);
						echo "<input type='checkbox' name='rem[]' value='$user' />$user<br>";
					}
				?>
				</form>
			</div>
		</div>
	</div>

</body>
</html>