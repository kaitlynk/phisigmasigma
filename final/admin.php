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
			
			<?php
				if (isset($_POST['newuser']) && isset($_POST['newpw'])) {
             		$newuser = $_POST['newuser'];
               		$newpw = md5($_POST['newpw']);
               		$users = mysql_query('SELECT username FROM users');
               		$numusers = mysql_num_rows($users);
               		$alreadyexists = false;
               		for ($j = 0; $j < $numusers - 1; $j++) {
						$user = mysql_result($users, $j);
						if (strcasecmp($newuser, $user) === 0) {
							$alreadyexists = true;
						}
					}
					if ($alreadyexists) {
						echo "<h5><font color = 'red'>ERROR: The username \"".$newuser."\" already exists. Please enter a different name.</font></h5>";
					}
	               	else if ($_POST['isadmin'] == isadmin) {
	                   	mysql_query('INSERT INTO users VALUES(\''.$newuser.'\', \''.$newpw.'\', 1)');
	                    echo "<h5>Successfully added administrator \"".$newuser."\" to the site.</h5>";
	              	}
	                else {
	                    mysql_query('INSERT INTO users VALUES(\''.$newuser.'\', \''.$newpw.'\', 0)');
	                    echo "<h5>Successfully added user \"".$newuser."\" to the site.</h5>";
	                }
	            }
	     	?>
	     	
		  	<?php
		  		if ($_POST['remsub'] == 1) {
		        	$rem = $_POST['rem'];
		        	if (empty($rem)) {
		        		echo "<h5><font color = 'red'>Please select users to delete.</font></h5>";
		        	}
		        	else {
		        		$numrem = count($rem);
		        		for ($i = 0; $i < $numrem; $i++) {
		        			mysql_query("DELETE FROM users WHERE username='".$rem[$i]."'");
		        		}
		        		echo "<h5>Successfully deleted users.</h5>";
		        	}
		        }
	        ?>
     	
		</div>
		
		<table width="100%">
		<tr>
		
		<td class = "dashboard">
		<div class='module'>
			<a href="#" onclick="$('#addsister').slideToggle();">
				<h3>
					Add Sister
				</h3>
			</a>
			<div id ='addsister'>
				text here
			</div>
		</div>
		
		<td class = "dashboard">
		<div class='module'>
			<a href="#" onclick="$('#pollresults').slideToggle();">		
				<h3>
					Poll Results
				</h3>
			</a>
			<div id = 'pollresults'>
				text here
			</div>
		</div>

		<!-- Edit Blogpost
			Connect to final proj database
			Select title from blogposts
			Display titles with checkboxes
			[Submit form will take to another php page with text fields with auto-filled title and content]
			Connect to final proj database
			Select currdate from blogposts where blogchange=title
			Get currdate
			Update users set title=new title, content=new content, oldcurrdate, currdate) -->
		
		</tr>
		<tr>
		<td class = "dashboard">
		<div class='module'>
			<a href="#" onclick="$('#addevent').slideToggle();">
				<h3>
					Add Event
				</h3>
			</a>
			<div id = 'addevent'>
				text here
			<!-- Add Event
				If POST[name], POST[date] is set
					Insert into blogposts values(id, POST[name], POST[date])
					Get currdate
					Insert into notifications values(currdate, actionid, event) -->
			</div>
		</div>
		
		<td class = "dashboard">
		<div class='module'>
			<a href="#" onclick="$('#addphoto').slideToggle();">
				<h3>
					Add Photo
				</h3>
			</a>
			<div id = 'addphoto'>
				text here
			</div>
		</div>
		
		</tr>
		<tr>
		<td class="dashboard">
		<div class ="module">
		<a href="#" onclick="$('#adduser').slideToggle();">
			<h3>
				Add User
			</h3>
		</a>
		<div id = "adduser">
			<h5>
				<form name='adduser' action='admin.php' method='post'>
				<table>
				<tr>
					<td>Username: 
					<td><input type='text' name='newuser'/>
				</tr>
				<tr>
					<td>Password: 
					<td><input type='text' name='newpw'/>
				</tr>
				</table>
				&nbsp;&nbsp;<input type='checkbox' name='isadmin' value='isadmin'/> Administrator <br>
				<div id ='right'><input type='submit' value='Create' onclick='return addcheck();'></div>
				</form>
     		</h5>
     	</div>
     	
     	
     	<td class="dashboard">
     	<div class ="module">
			<a href="#" onclick="$('#listusers').slideToggle();">
				<h3>
					Edit Users
				</h3>
			</a>        
       	<div id = "listusers">
       		<h5>
        	<form name='removeuser' action='admin.php' method='post'>
         		<?php
         			$usersarr = array();
       				$adminarr = array();
               		$users = mysql_query('SELECT* FROM users');
               		$numusers = mysql_num_rows($users);
               		for ($j = 0; $j < $numusers; $j++) {
						$user = mysql_fetch_row($users);
						if ($user[2] == 0) {
							array_push($usersarr,$user[0]);
						}
						else {
							array_push($adminarr,$user[0]);
						}
					}
					echo "<table width='100%'><tr><td class='dashboard'><b>Users</b><br>";
					for ($i = 0; $i < count($usersarr); $i++) {
						echo "<input type='checkbox' name='rem[]' value='$usersarr[$i]' />&nbsp;$usersarr[$i]<br>";
					}
					echo "<td class='dashboard'><b>Administrators</b><br>";
					for ($i = 0; $i < count($adminarr); $i++) {
						echo "<input type='checkbox' name='rem[]' value='$adminarr[$i]' />&nbsp;$adminarr[$i]<br>";
					}
					echo "</tr></table>";
				?>
				<br>
				<input type='hidden' name='remsub' value='1'>
				<input type='submit' value='Remove' onclick='return removecheck();'>
			</form>
			</h5>
		</div>
		</div>
		</tr></table>
		
		<div class='module'>
			<a href="#" onclick="$('#addblog').slideToggle();">		
				<h3>
					Add Blog
				</h3>
			</a>
			<div id = 'addblog'>
				<form name='blog' action='blog.php' method='post'>
					<h5>
						Title: <input type='text' name='blogtitle' maxlength='50' size='50'><br><br>
						<input type='hidden' name='author' value='<?php echo $_SESSION['logged_user']; ?>'>
						<div id ='center'><textarea name='content' rows='20' cols='107'></textarea></div><br>
						<div id ='right'><input type='submit' value='Post Blog' onclick='return blogcheck();'></div>
					</h5>
				</form> 
			<!-- Add Blogpost
				If POST[blogcontent], POST[title] is set
				Get currdate
				Insert into blogposts values(id, POST[title], POST[blogcontent], currdate, currdate) 
				Insert into notifications values(currdate, actionid, blog) -->
			</div>
		</div>
	</div>
	<br>
</body>
</html>