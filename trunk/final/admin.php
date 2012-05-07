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
				<li>ABOUT</li>
			<?php if (isset($_SESSION['logged_user'])) {
				echo "<li>EVENTS</li>
				<li>PHOTOS</li>";
			} ?>
				<li>CONTACT</li>
			</ul>
			<div class="user">
				Welcome, <?php echo $_SESSION['logged_user'];?>!
				<br>
				<a class="logout" href="logout.php">Logout</a>
			</div>		
		</div>
	</div>
	<div class="ribbon_bottom">
		<div class="center">
			<h2>
				Dashboard
			</h2>
		</div>
	</div>
	<div class="center">
		<!-- Add Blogpost
			If POST[blogcontent], POST[title] is set
				Get currdate
				Insert into blogposts values(id, POST[title], POST[blogcontent], currdate, currdate) -->
				Insert into notifications values(currdate, actionid, blog)
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
	
		<div class="module" id="newuser">
			<!-- Add User -->
			<?php
				$con = mysql_connect('localhost','root','kkk524425kk');
				if (!$con) {
  					die('Could not connect: ' . mysql_error());
 				}
 				mysql_select_db('test_Final_Project', $con);
 				$un = $_SESSION['logged_user'];
 				$users = mysql_query('SELECT isAdmin FROM users WHERE username='.$un);
 				echo mysql_fetch_row($users)."hi";
 				if (mysql_fetch_row($users) == 1) {
 					if (isset($_POST['newusername']) && isset($_POST['newpw'])) {
 						$newun = $_POST['newusername'];
 						$newpw = $_POST['newpw'];
 						if ($_POST['isadmin'] == 'isadmin') {
 							mysql_query('INSERT INTO users VALUES($newun,$newpw, 1');
 						}
 						else {
 							mysql_query('INSERT INTO users VALUES($newun,$newpw, 0');
 						}
 					}
 					
				 	echo "<h3>
							Add User
						</h3>
						<p>
							<form id='adduser' action='dashboard.php' method='post'>
								Username: <input type='text' name='newusername'/>
								Password: <input type='password' name='newpw'/>
								<input type='checkbox' name='isadmin' value='isadmin'/> Admin
								<input type='submit' name='submit' value='Create'/>
							</form>
						</p>";
				}
 				
			?>
		</div>
	</div>

</body>
</html>