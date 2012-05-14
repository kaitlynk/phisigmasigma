<?php
session_start();
include_once('db.inc');
$con = mysql_connect($host,$username,$password);

if (!$con) {
    die('Could not connect: '. mysql_error());
	}
	
mysql_select_db(test_Final_Project, $con);
if(isset($_POST['addphoto']) && isset($_FILES['photo'])) {
	echo'hi';
	if($_FILES['photo']['error'] > 0) {
		$error = "The file to selected could not be uploaded.";
	}
	else {
		include_once("functions.php");
		$path = uniqid().$_FILES['photo']['name'];

		if(cropImage($path, 200, 140, 500, 360) == 'error') {
			$message = '<p class="error">That file format is not supported</p>';
		}
		else {
			$mysql = new mysqli($host, $username, $password, $database);

			$caption = $mysql->real_escape_string($_POST['caption']);

			$mysql->query("INSERT INTO photos(path_small, path_large,dateadded,caption) VALUES('".$path."','large_".$path."',NOW(),'".$caption."')");
			$mysql->query("INSERT INTO notifications(datetime, actionid, type) VALUES(NOW(), LAST_INSERT_ID(), 'photo')");
			$mysql->query("INSERT INTO photoInAlbum(albumid,photoid) VALUES(".$_POST['albumid'].",LAST_INSERT_ID())");
			$mysql->query("UPDATE albums SET datemodified = NOW() WHERE id = $_POST[albumid]");
			$mysql->close();
		}
	}
}
if (isset($_POST['newuser']) && isset($_POST['newpw'])) {
	$newuser = mysql_real_escape_string($_POST['newuser']);
	$firstname = mysql_real_escape_string($_POST['firstname']);
	$lastname = mysql_real_escape_string($_POST['lastname']);
	$newpw = mysql_real_escape_string(md5($_POST['newpw']));
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
	$message = "<p>ERROR: The username \"".$newuser."\" already exists. Please enter a different name.</p>";
}
	else if (isset($_POST['isadmin'])) {
   	mysql_query("INSERT INTO users(username, password, firstname, lastname, isAdmin) VALUES('".$newuser."', '".$newpw."','".$firstname."','".$lastname."', 1)");
    mysql_query("INSERT INTO notificationsViewed(username,lastViewed) VALUES('".$newuser."',NOW())");
    $message = "<p>Successfully added administrator \"".$newuser."\" to the site.</p>";
	}
else {
   	mysql_query("INSERT INTO users(username, password, firstname, lastname, isAdmin) VALUES('".$newuser."', '".$newpw."','".$firstname."','".$lastname."', 0)");
    mysql_query("INSERT INTO notificationsViewed(username,lastViewed) VALUES('".$newuser."',NOW())");
    $message = "<p>Successfully added user \"".$newuser."\" to the site.</p>";
}
}
if (isset($_POST['remsub'])) {
$rem = $_POST['rem'];
if (empty($rem)) {
	$message = "<p>Please select users to delete.</p>";
}
else {
	$numrem = count($rem);
	for ($i = 0; $i < $numrem; $i++) {
		$remun = explode(" ",$rem[$i]);
		$delsucc = mysql_query("DELETE FROM users WHERE username='".$remun[0]."'");
		if (!$delsucc) {
			$message = "<p>Users could not be deleted. Please try again.</p>";
		}
	}
	$message = "<p>Successfully deleted users.</p>";
}
}
if(isset($_POST['submit'])) {
	mysql_query("INSERT INTO albums(name, datecreated) VALUES('".$_POST['name']."', CURDATE())");
}
if(isset($_POST['deletealbum'])) {
	$mysql = new mysqli($host, $username, $password, $database);

	$mysql->query("DELETE FROM albums WHERE id=".$_POST['albumid']);
	$message = "<p>The album has been successfully removed</p>";
}
if(isset($_POST['resetvotes'])) {
	$mysql = new mysqli($host, $username, $password, $database);

	$mysql->query("DELETE FROM votes");
	$message = "<p>The votes have been reset.</p>";
}

if (isset($_POST['createevent']) || isset($_POST['edited'])) {	
	$ename = mysql_real_escape_string($_POST['eventname']);
	$eloc = mysql_real_escape_string($_POST['eventloc']);
	$etime = $_POST['eventtime'];
	date_default_timezone_set("America/New_York");
	$month = $_POST['month'];
	$date = $_POST['date'];
	$year = $_POST['year'];
	$hour = $_POST['hour'];
	$mins = $_POST['mins'];
		
	if ($hour > 12 || $hour < 1 || $mins > 59 || $mins < 0) {
		$message = "<p>Please enter a valid time and try again.</p>";
	}
	else {
		if (isset($_FILES['eventpic'])) {
			include_once("functions.php");
			$path = uniqid().$_FILES['eventpic']['name'];

			if(cropImage($path, 200, 140, 500, 360) == 'error') {
				$message = '<p class="error">That file format is not supported</p>';
			}
				
			else {
				$longpath = "long_".$path;
				$datetime = new DateTime();
				$datetime = date_date_set($datetime, $year, $month, $date);
				$ampm = $_POST['ampm'];
				if ($ampm == "PM") {
					$hour = $hour + 12;
				}
					
				$datetime = date_time_set($datetime, $hour, $mins);
				$datetime = date_format($datetime,'Y-m-d H:i:s');
				
				if (isset($_POST['public'])) {
					$epub = 1;
				}	
			 	else {$epub = 0;}
					
				if (isset($_POST['createevent'])) {		
					$equery = mysql_query("INSERT INTO events(name, location, datetime, public) VALUES('".$ename."', '".$eloc."', '".$datetime."', '".$epub."')");
					$geteidq = mysql_query("SELECT MAX(id) FROM events");
					$epquery = mysql_query("INSERT INTO photos(caption, path_small, path_large, dateadded) VALUES('".$ename."', '".$path."', '".$longpath."','".$datetime."')");
					$geteid = mysql_fetch_row($geteidq);					
					$getpidq = mysql_query("SELECT id FROM photos WHERE path_small='".$path."'");
					$getpid = mysql_fetch_row($getpidq);
					$epquery = mysql_query("INSERT INTO photoInEvent(eventid, photoid) VALUES('".$geteid[0]."','".$getpid[0]."')");
					$message = "<p>Successfully added event!</p>";
					if (!epquery) {
						die('Invalid query: ' . mysql_error());
						$message = "<p>Event could not be added. Please try again.</p>";
					}
				}
					
				else {
					$id = $_POST['editedid'];
					$equery = mysql_query("UPDATE events SET name='".$ename."', location='".$eloc."', datetime='".$datetime."', public='".$epub."' WHERE id='".$id."'");
					$message = "<p>Successfully updated event!</p>";
					if (!$equery) {
						$message = "<p>Event could not be edited. Please try again.</p>";
					}
				}
			}
		}
	}
}

if (isset($_POST['remeve'])) {
	$eves = $_POST['remev'];
	if (empty($eves)) {
		$message = "<p>Please select events to delete.</p>";
	}
	else {
		$numeves = count($eves);
		for ($i = 0; $i < $numeves; $i++) {
			$evedelsucc = mysql_query("DELETE FROM events WHERE id='".$eves[$i]."'");
			if (!$evedelsucc) {
				$message = "<p>Events could not be deleted. Please try again.</p>";
			}
		}
		$message = "<p>Successfully deleted events.</p>";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="style.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Phi Sigma Sigma</title>
<script type="text/javascript" src="https://use.typekit.com/ahu5nxd.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="jquery.smoothDivScroll-1.2.js"></script>
<script type="text/javascript" src="phisigsig.js"></script>
</head>
<body>
	<!-- Welcome, <?php 
               		$un = $_SESSION['logged_user'];
               		$admin = mysql_query("SELECT isAdmin FROM users WHERE username='".$un."'");
               		$adminresult = mysql_fetch_row($admin);
               		if ($adminresult[0] == 1) {
						echo "<a href = admin.php><div class='user'><u>".$un."</u>!</div>";
					}
					else {
						echo "notadmin".$un."!";
					}

					?> -->
	<div class="header">
		<div class="center">
			<h4>
				ΦΣΣ
			</h4>
			<?php
			if(!isset($_SESSION['logged_user'])) {
				echo '<button class="login_button" onclick="$(\'#login\').slideToggle(100);">
					Login
					</button>';
			}
			else {
				echo '<a href="logout.php" class="login_button">
					Logout
					</a>';
			}
			if(isset($errortext))
				echo $errortext;
			?>
		</div>
	</div>
	<div class="buffer"></div>
	<div class="center">
		<div class="nav">
		<?php
		if(!isset($_SESSION['logged_user'])) {
			echo '<div id="login">
				<form name="login" action="index.php" method="post">
                <input name="username" type="text" class="text"/>
                <input type="password" name="pw" class="text"/>
                <input type="submit" name="login" class="login_button"/>
           		</form>
				</div>';
		}
		?>
		<h1>
			Phi Sigma Sigma.
		</h1>
			<ul>
				<li>
					Home
				</li>
				<li>
					History
				</li>
				<li>
					Contact
				</li>
				<li>
					<button>Blog</button>
				</li>
			</ul>

		</div>
	</div>
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="middle">
		<?php
		if(isset($message))
			echo $message;
		?>
		<div class="column">
		    <div class="module_wrapper_small">
		        <div class="module">
		        <h3 onclick="$(this).next('.hidden').slideToggle(200)">
					Add a User
				</h3>
				<div class="hidden">
			        <form name='adduser' action='admin.php' method='post'>
						<h4>Username</h4>
						<p>
							<input type='text' name='newuser' class="text"/>
						</p>
						<h4>Password</h4>
						<p>
							<input type='password' name='newpw' class="text"/>
						</p>
						<h4>First name</h4>
						<p>
							<input type='text' name='firstname' class="text"/>
						</p>
						<h4>Last name</h4>
						<p>
							<input type='text' name='lastname' class="text"/>
						</p>
						<p>
							<input type='checkbox' name='isadmin' value='isadmin'/> Administrator
						</p>
						<p>
							<input type='submit' value='Create' class="button" onclick='return addcheck();'>
						</p>
					</form>
				</div>
			</div>
		</div>
		<div class="module_wrapper_small">
			<div class="module">
				<h3 onclick="$(this).next('.hidden').slideToggle(200)">
					Add photos
				</h3>
				<div class="hidden">
					<span class="watermark">
						add an album...
					</span>
					
					<form name="album" action="admin.php" method="post">
						<h4>
							Name
						</h4>
						<p>
							<input type='text' name='name' class="text"/>
						</p>
						<p>
							<input type='submit' value='Add' name="submit" class="button"/>
						</p>
					</form>
					<div class="separator"></div>
					<span class="watermark">
						add a photo to an album...
					</span>
					<form action="admin.php" method="post" enctype="multipart/form-data">
						<h4>
							Album
						</h4>
						<select name="albumid" class="albsel">
							<?
							$mysql = new mysqli($host, $username, $password, $database);
							$albums = $mysql->query("SELECT id, name FROM albums");
							while($album = $albums->fetch_assoc()) {
								echo "<option value='".$album['id']."'>".$album['name']."</option>";
							}
							?>
						</select>
						<h4>
							Photo
						</h4>
						<p>
							<input type="file" name="photo" id="file"/>
						</p>
						<h4>
							Caption
						</h4>
						<p>
							<input class="text" name="caption" type="text"/>
						</p>
						<p>
							<input type="submit" class="button" name="addphoto" value="Add Photo"/>
						</p>
					</form>
				</div>
			</div>
		</div>
		<div class="module_wrapper_small">
			<div class="module">
		        <h3 onclick="$(this).next('.hidden').slideToggle(200)">
					Add an Event
				</h3>
				<div class="hidden">
			        <form name='addevent' action='admin.php' method='post' enctype = 'multipart/form-data'>
						<h4>Event Name</h4>
						<p>
							<input type='text' name='eventname' class="text"/>
						</p>
						<h4>Location</h4>
						<p>
							<input type='text' name='eventloc' class="text"/>
						</p>
						<h4>Date</h4>
						<form name = 'dateofe' method = 'POST' action = 'mainck.php'>
								<select name = 'month' onchange = 'return ajaxfunc(this.value);'>
									<option value = '01'>January</option>
									<option value = '02'>February</option>
									<option value = '03'>March</option>
									<option value = '04'>April</option>
									<option value = '05'>May</option>
									<option value = '06'>June</option>
									<option value = '07'>July</option>
									<option value = '08'>August</option>
									<option value = '09'>September</option>
									<option value = '10'>October</option>
									<option value = '11'>November</option>
									<option value = '12'>December</option>
								</select>
								<select name = 'date' id = 'date'>
									<?php
									for ($i = 1; $i < 31; $i++) {
									echo "<option value = '".$i."'>".$i."</option>";
									}
									?>
								</select>
								<input type = 'text' name = 'year' maxlength = '4' size = '4' class='yeartext' value = '2012'>
							
						<h4>Time</h4>
						<input type = 'text' name = 'hour' maxlength = '2' size = '2' class='timetxt' id = 'hour'>:&nbsp;&nbsp;&nbsp;&nbsp;<input type = 'text' name = 'mins' maxlength = '2' size = '2' class='timetxt' id = 'mins'>
						<select name = 'ampm'>
							<option value = 'AM'>AM</option>
							<option value = 'PM'>PM</option>
						</select>
						<h4>Picture:</h4>
						<p>
							<input type = 'file' name = 'eventpic' accept = 'image/*'></h4>
						</p>
						<p>
							<input type='checkbox' name='public' value='public'/> Public Event
						</p>
						<p>
							<input type='submit' name='createevent' value='Create' class="button" onclick='return eventcheck();'>
						</p>
					</form></form>
				</div>
			</div>
		</div>
	</div>
	<div class="column">
		<div class="module_wrapper_small">
			<div class="module">
				<h3 onclick="$(this).next('.hidden').slideToggle(200)">
					Remove a User
				</h3>
				<div class="hidden">
					<form name='removeuser' action='admin.php' method='post'>
	         		<?php
	         			$usersarr = array();
	       				$adminarr = array();
	               		$users = mysql_query('SELECT* FROM users');
	               		$numusers = mysql_num_rows($users);
	               		for ($j = 0; $j < $numusers; $j++) {
							$user = mysql_fetch_row($users);
							$fullname = $user[1]." (".$user[2]." ".$user[3].")";
							if ($user[5] == 0) {
								array_push($usersarr,$fullname);
							}
							else {
								array_push($adminarr,$fullname);
							}
						}
						echo "<h4>Users</h4>";
						for ($i = 0; $i < count($usersarr); $i++) {
							echo "<p><input type='checkbox' name='rem[]' value='$usersarr[$i]' />$usersarr[$i]</p>";
						}
						
						echo "<h4>Administrators</h4>";
						
						for ($i = 0; $i < count($adminarr); $i++) {
							echo "<p><input type='checkbox' name='rem[]' value='$adminarr[$i]' />$adminarr[$i]</p>";
						}
					?>
					<p>
						<input type='hidden' name='remsub' value='1'>
					</p>
					<p>
						<input type='submit' value='Remove' onclick='return removecheck();' class="button">
					</p>
					</form>
				</div>
			</div>
		</div>
		<div class="module_wrapper_small">
			<div class="module">
				<h3 onclick="$(this).next('.hidden').slideToggle(200)">
					Delete an Album
				</h3>
				<div class="hidden">
					<form action='admin.php' method='post'>
	         			<select name="albumid">
							<?
							$mysql = new mysqli($host, $username, $password, $database);
							$albums = $mysql->query("SELECT id, name FROM albums");
							while($album = $albums->fetch_assoc()) {
								echo "<option value='".$album['id']."'>".$album['name']."</option>";
							}
							?>
						</select>
						<p>
							<input type='submit' name="deletealbum" class="button">
						</p>
					</form>
				</div>
			</div>
		</div>
		<div class="module_wrapper_small">
			<div class="module">
				<h3 onclick="$(this).next('.hidden').slideToggle(200)">
					Delete an Event
				</h3>
				<div class="hidden">
					<form name='removeevent' action='admin.php' method='post'>
		         		<?php
							$events = mysql_query('SELECT* FROM events ORDER BY datetime');
		               		$numevents = mysql_num_rows($events);
		               		for ($j = 0; $j < $numevents; $j++) {
								$event = mysql_fetch_row($events);
								$eventq = date_create($event[3]);
								$eventd = date_format($eventq, 'F j, Y @ g:ia');
								$eventdesc = $event[1]." (".$eventd.")";
								echo "<p class = 'blogtext'><input type='checkbox' name='remev[]' value='$event[0]' />$eventdesc</p>";
							}
						?>
						<p>
							<input type='hidden' name='remevent' value='1'>
						</p>
						<p>
							<input type='submit' name='remeve' value='Remove' class="button">
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="clear"></div>
	<div class="center_module">
		<div class="module">
			<h3 onclick="$(this).next('.hidden').slideToggle(200)">
				Add a Blog Post
			</h3>
			<div class="hidden">
				<form name='blog' action='blog.php' method='post'>
					<h4>
						Title
						<input type='text' class="text" name='blogtitle' maxlength='50' size='50'><br><br>
					<a href="javascipt:'';" onmousedown = 'return addb();' class='addblogstuff'>B</a>
					<a href="javascipt:'';" onmousedown = 'return addi();' class='addblogstuff'><i>I</i></a>
					<a href="javascipt:'';" onmousedown = 'return addu();' class='addblogstuff'><u>U</u></a>
					<a href="javascipt:'';" onclick = 'return addbr();' class='addblogstuff'>Add Line Break</a>
					<a href="javascipt:'';" onclick = "$('#addblogimg').slideToggle();" class='addblogstuff'>Add Image</a>
					
					<div id = 'addblogimg'>
						URL: <input type = 'text' name = 'imgurl'> &nbsp;
						Size: <input type = 'radio' name='imgsize' value='small' checked>Small &nbsp;
						<input type = 'radio' name='imgsize' value='medium'>Medium &nbsp;
						<input type = 'radio' name='imgsize' value='large'>Large &nbsp; &nbsp;
						<p onclick='return addabi();' class='addlink'>Add Code</p>
					</div>
					</h4>
					<input type='hidden' name='author' value='<?php echo $_SESSION['logged_user']; ?>'>
					<p>
						<textarea name='content' rows='20' cols='107'></textarea>
					</p>
					<p>
						<input type='submit' class="button" value='Post Blog' onclick='return blogcheck();'>
					</p>
				</form> 
			</div>
		</div>
	</div>
	<div class="center_module">
		<div class="module">
			<h3 onclick="$(this).next('.hidden').slideToggle(200)">
				Sister of the Month Results
			</h3>
			<div class="hidden">
				<?php
				$mysql = new mysqli($host, $username, $password, test_Final_Project);

				$results = $mysql->query("SELECT firstname,num FROM users as u JOIN (SELECT COUNT(*) as num,candidateid FROM votes GROUP BY candidateid) as v ON (u.id = v.candidateid)");
				$sum = $mysql->query("SELECT COUNT(*) as sum FROM votes");
				$sum = $sum->fetch_assoc();
				$sum = $sum['sum'];
				while($result = $results->fetch_assoc()) {
					echo "<p>".$result['firstname']."</p>";
					echo '<div class="bar" style="width:'.$result['num']*100/$sum.'%"><p>'.$result['num']." votes</p></div>";
				}
				?>
				<form action='admin.php' method='post'>
					<p>
						<input type='submit' name="resetvotes" class="button" value='Reset Votes'>
					</p>
				</form> 
			</div>
		</div>
	</div>
	<div class="center_module">
		<div class="module">
			<h3 onclick="$(this).next('.hidden').slideToggle(200)">
				View Events
			</h3>
			<div class="hidden">
				<?php
					$alleventsq = mysql_query('SELECT* FROM events ORDER BY datetime');
					if (!$alleventsq) {
    					die('Invalid query: ' . mysql_error());
					}
					$numevents = mysql_num_rows($alleventsq);
					if ($numevents == 0) {
						echo "There are currently no events scheduled!";
					}
					else {
						for ($i = 0; $i < $numevents; $i++) {
								$currevent = mysql_fetch_row($alleventsq);
								$curreventq = date_create($currevent[3]);
								$curreventd = date_format($curreventq, 'l, F j, Y @ g:ia');
								$curreventpidq = mysql_query("SELECT photoid FROM photoInEvent WHERE eventid='".$currevent[0]."'");
								$curreventpid = mysql_fetch_row($curreventpidq);
								$curreventpq = mysql_query("SELECT path_small FROM photos WHERE id='".$curreventpid[0]."'");
								$curreventp = mysql_fetch_row($curreventpq);
								echo "<div class = 'module'>
										<div class='eventstitle'>
											$currevent[1]
											<div class = 'author'> 
												$curreventd
												<div class='loctext'>
													$currevent[2]
												</div>
											</div>
										</div>";
										if (mysql_result($admin, 0) == 1) {
											echo "<form name='editevent' action='editevent.php' method='post'>
											<input type='submit' value='Edit' class = 'edit'>
											<input type='hidden' name='editid' value='$currevent[0]'>
											</form>";
										}
										echo "<table><tr><td>
											<img class = 'dispevpic' src = 'photos/".$curreventp[0]."'></td>";
								if (!($currevent[4] == null)) {
									echo "<td class = 'blogtext'>RSVP'd: ".$currevent[4]."</td>";
								}
								else {
									echo "<td class='blogtext'>No one is currently attending!</td>";
								}
							}
						echo "</tr></table></div>";
					}
					?>
			</div>
		</div>
	</div>
</div>
</body>
</html>