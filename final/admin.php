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
				Welcome, <?php echo $_SESSION['logged_user'];?>!
				<br>
				<a class="logout" href="logout.php">Logout</a>
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
			<!-- Add User -->

 					
			<h3>
				Add User
			</h3>
			<p>
				<form id='adduser' action='dashboard.php' method='post'>
					Username: <input type='text' name='newusername'/><br>
					Password: <input type='password' name='newpw'/><br>
					<input type='checkbox' name='isadmin' value='isadmin'/> Make Administrator <br>
					<input type='submit' name='submit' value='Create'/>
				</form>
			</p>
		</div>
	</div>

</body>
</html>