<?
session_start();
if(!isset($_SESSION['logged_user']))
	header('location: index.php');
include_once('db.inc');
$con = mysql_connect($host,$username,$password);
$mysql = new mysqli($host, $username, $password, $database);

if($_SESSION['isAdmin'] == 0)
	header('location: index.php');

if (!$con) {
    die('Could not connect: '. mysql_error());
	}
	
	mysql_select_db($database, $con);
if(isset($_POST['addphoto']) && isset($_FILES['photo'])) {
	if($_FILES['photo']['error'] > 0) {
		$error = "The file to selected could not be uploaded.";
	}
	else {
		include_once("functions.php");
		$path = uniqid().$_FILES['photo']['name'];

		if(cropImage($path, 200, 140, 500, 360) == 'error') {
			$message = '<p class="error">That file format is not supported.</p>';
		}
		else {

			$caption = $mysql->real_escape_string($_POST['caption']);

			$mysql->query("INSERT INTO photos(path_small, path_large,dateadded,caption) VALUES('".$path."','large_".$path."',NOW(),'".$caption."')");
			$mysql->query("INSERT INTO notifications(datetime, actionid, type) VALUES(NOW(), LAST_INSERT_ID(), 'photo')");
			$mysql->query("INSERT INTO photoInAlbum(albumid,photoid) VALUES(".$_POST['albumid'].",LAST_INSERT_ID())");
			$mysql->query("UPDATE albums SET datemodified = NOW() WHERE id = $_POST[albumid]");
			$mysql->close();
			$message= "<p>That photo has been added.</p>";
		}
	}
}
if (isset($_POST['newuser']) && isset($_POST['newpw'])) {
	$newuser = $_POST['newuser'];
	$firstname = $mysql->real_escape_string($_POST['firstname']);
	$lastname = $mysql->real_escape_string($_POST['lastname']);
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
	$message = "<p>The username \"".$newuser."\" already exists. Please enter a different name.</p>";
}
	else if (isset($_POST['isadmin'])) {
	$username = $mysql->real_escape_string($newuser);
   	$mysql->query("INSERT INTO users(username, password, firstname, lastname, isAdmin) VALUES('".$username."', '".$newpw."','".$firstname."','".$lastname."', 1)");
    $mysql->query("INSERT INTO notificationsViewed(username,lastViewed, lastRetrieved) VALUES('".$username."',NOW(),NOW())");
    $message = "<p>Successfully added administrator \"".$newuser."\" to the site.</p>";
	}
else {
	$username = $mysql->real_escape_string($newuser);
   	$mysql->query("INSERT INTO users(username, password, firstname, lastname, isAdmin) VALUES('".$username."', '".$newpw."','".$firstname."','".$lastname."', 0)");
    $mysql->query("INSERT INTO notificationsViewed(username,lastViewed,lastRetrieved) VALUES('".$username."',NOW(),NOW())");
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
		mysql_query("DELETE FROM users WHERE username='".$mysql->real_escape_string($rem[$i])."'");
	}
	$message = "<p>Successfully deleted users.</p>";
}
}
if(isset($_POST['submit'])) {
	$name = $mysql->real_escape_string($_POST['name']);
	$num = $mysql->query("SELECT COUNT(*) AS num FROM albums WHERE name = '".$name."'");
	$num = $num->fetch_assoc();
	$num = $num['num'];
	if($num > 0) 
		$message = "<p>An album with that name already exists.</p>";
	else {
		$mysql->query("INSERT INTO albums(name, datecreated) VALUES('".$name."', CURDATE())");
		$mysql->query("INSERT INTO notifications(datetime, actionid, type) VALUES(NOW(), LAST_INSERT_ID(), 'album')");
		$message = "<p>The album has been successfully added.</p>";
	}
}
if(isset($_POST['deletealbum'])) {
	$mysql->query("DELETE FROM albums WHERE id=".$_POST['albumid']);
	$message = "<p>The album has been successfully removed</p>";
}
if(isset($_POST['resetvotes'])) {
	$mysql->query("DELETE FROM votes");
	$message = "<p>The votes have been reset.</p>";
}
if (isset($_POST['createevent']) || isset($_POST['edited'])) {	
	$ename = mysql_real_escape_string($_POST['eventname']);
	$eloc = mysql_real_escape_string($_POST['eventloc']);
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
		$datetime = new DateTime();
		$datetime = date_date_set($datetime, $year, $month, $date);
		$ampm = $_POST['ampm'];
		if ($ampm == "PM") {
			$hour += 12;
		}
							
		$datetime = date_time_set($datetime, $hour, $mins);
		$datetime = date_format($datetime,'Y-m-d H:i:s');
					
		if (isset($_POST['public'])) {
			$epub = 1;
		}	
					
		else {$epub = 0;}
						
		if (isset($_POST['createevent'])) {
			$equery = $mysql->query("INSERT INTO events(name, location, datetime, public) VALUES('".$ename."', '".$eloc."', '".$datetime."', '".$epub."')");
			$message = "<p>Successfully added event.</p>";
			if (!$equery) {
				$message = "<p>Event could not be added. Please try again.</p>";
			}
			$mysql->query("INSERT INTO notifications(datetime, actionid, type) VALUES(NOW(), LAST_INSERT_ID(), 'event')");
		}
							
		else {
			$id = $_POST['editedid'];
			$equery = $mysql->query("UPDATE events SET name='".$ename."', location='".$eloc."', datetime='".$datetime."', public='".$epub."' WHERE id='".$id."'");
			$message = "<p>Successfully updated event!</p>";
			if (!$equery) {
				$message = "<p>Event could not be edited. Please try again.</p>";
			}
		}
		
		if (isset($_FILES['photo'])) {
			if($_FILES['photo']['error'] > 0) {
				$message = "<p>The event image could not be uploaded.</p>";
			}
			else {
				include_once("functions.php");
				$epath = uniqid().$_FILES['photo']['name'];

				if(cropImage($epath, 200, 140, 500, 360) == 'error') {
					$message = '<p class="error">That file format is not supported</p>';
				}
				else {
					$elongpath = "long_".$epath;
					$epquery = $mysql->query("INSERT INTO photos(caption, path_small, path_large, dateadded) VALUES('".$ename."', '".$epath."', '".$elongpath."', NOW())");
					$getpidq = $mysql->query("SELECT id FROM photos WHERE path_small='".$epath."'");
					$getpid = $getpidq->fetch_row();
					if (!$getpidq) {
   						 die('Invalid query: ' . mysql_error());
					}
					
					if (isset($_POST['createevent'])) {
						$geteidq = $mysql->query("SELECT MAX(id) FROM events");
						$geteid = $geteidq->fetch_row();
						$id = $geteid[0];				
						$message = '<p>Successfully created event!</p>';
					}
					else {
						$getoldpq = $mysql->query("SELECT photoid FROM photoInEvent WHERE eventid='".$id."'");
						$oldp = $getoldpq->fetch_row();
						$mysql->query("DELETE FROM photos WHERE id='".$oldp[0]."'");
						$mysql->query("DELETE FROM photoInEvent WHERE photoid='".$oldp[0]."'");
						$message = '<p>Successfully updated event!</p>';
					}
					$epquery = $mysql->query("INSERT INTO photoInEvent(eventid, photoid) VALUES('".$id."','".$getpid[0]."')");
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
			$getpidq = mysql_query("SELECT photoid FROM photoInEvent WHERE eventid='".$eves[$i]."'");
			$getpid = mysql_fetch_row($getpidq);
			$pdelsucc = mysql_query("DELETE FROM photos WHERE id='".$getpid[0]."'");
			$pinedelsucc = mysql_query("DELETE FROM photoInEvent WHERE eventid='".$eves[$i]."'");
			if (!$evedelsucc || !$pdelsucc || !$pinedelsucc) {
				$message = "<p>Events could not be deleted. Please try again.</p>";
			}
		}
		$message = "<p>Successfully deleted events.</p>";
	}
}
if(isset($_POST['postnews'])) {
	$title = $mysql->real_escape_string($_POST['newstitle']);
	$content = $mysql->real_escape_string($_POST['content']);
	$mysql->query("INSERT INTO news(title,content,datetime) VALUES('".$title."','".$content."',NOW())");
	$message = "<p>Successfully added the news post.</p>";
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
<script type="text/javascript" src="notify.js"></script>
</head>
<body>
	<?
		include('header.php');
	?>
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="middle">
		<?
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
			        <form action='admin.php' method='post'>
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
						<div id ='right'>
							<p>
								<input type='submit' value='Create' class="button" onclick='return addcheck();'/>
							</p>
						</div>
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
					
					<form action="admin.php" method="post">
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
						<p>
						<select name="albumid">
							<?
							$mysql = new mysqli($host, $username, $password, $database);
							$albums = $mysql->query("SELECT id, name FROM albums");
							while($album = $albums->fetch_assoc()) {
								echo "<option value='".$album['id']."'>".$album['name']."</option>";
							}
							?>
						</select>
						</p>
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
						<form name = 'dateofe' method = 'POST' action = 'mainck.php' enctype='multipart/form-data'>
								<select name = 'month' onchange = 'return ajaxfunc(this.value);' class="month">
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
								<select name = 'date' id = 'date' class="day">
									<?php
									for ($i = 1; $i < 31; $i++) {
									echo "<option value = '".$i."'>".$i."</option>";
									}
									?>
								</select>
								<input type = 'text' name = 'year' maxlength = '4' size = '4' class='yeartext' value = '2012'>
							
						<h4>Time</h4>
						<input type = 'text' name = 'hour' maxlength = '2' size = '2' class='timetxt' id = 'hour'>:<input type = 'text' name = 'mins' maxlength = '2' size = '2' class='timetxt' id = 'mins'>
						<select name = 'ampm' class="ampm">
							<option value = 'AM'>AM</option>
							<option value = 'PM'>PM</option>
						</select>
						<h4>Picture:</h4>
						<p>
							<input type = 'file' name = 'photo' accept = 'image/*'></h4>
						</p>
						<p>
							<input type='checkbox' name='public' value='public'/> Public Event
						</p>
						<p>
							<input type='submit' name='createevent' value='Create' class="button" onclick='return eventcheck();'>
						</p>
					</form>
				</div>
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
					<form action='admin.php' method='post'>
	         		<?php
	         			$usersarr = array();
	       				$adminarr = array();
	               		$users = mysql_query('SELECT* FROM users');
	               		$numusers = mysql_num_rows($users);
	               		for ($j = 0; $j < $numusers; $j++) {
							$user = mysql_fetch_row($users);
							if ($user[5] == 0) {
								array_push($usersarr,$user[1]);
							}
							else {
								array_push($adminarr,$user[1]);
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
						<input type='hidden' name='remsub' value='1'/>
					</p>
					<p>
						<input type='submit' value='Remove' onclick='return removecheck();' class="button"/>
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
						<p>
	         			<select name="albumid">
							<?
							$mysql = new mysqli($host, $username, $password, $database);
							$albums = $mysql->query("SELECT id, name FROM albums");
							while($album = $albums->fetch_assoc()) {
								echo "<option value='".$album['id']."'>".$album['name']."</option>";
							}
							?>
						</select>
						</p>
						<p>
							<input type='submit' name="deletealbum" class="button"/>
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

	</div>
	<div class="clear"></div>
	<div class="center_module">
		<div class="module">
			<h3 onclick="$(this).next('.hidden').slideToggle(200)">
				Add a Blog Post
			</h3>
			<div class="hidden">
				<form action='blog.php' method='post'>
					<h4>
						Title
					</h4>
					<p>
						<input type='text' class="text" name='blogtitle' maxlength='50' size='50'/>
					</p>
					<p>
						<input type='hidden' name='author' value='<?php echo $_SESSION['logged_user']; ?>'/>
					</p>
					<h4>
						Content
					</h4>
					<p>
						<textarea name='content'></textarea>
					</p>
					<p>
						<input type='submit' class="button" value='Post Blog' onclick='return blogcheck();'/>
					</p>
				</form> 
			</div>
		</div>
	</div>
	<div class="center_module">
		<div class="module">
			<h3 onclick="$(this).next('.hidden').slideToggle(200)">
				Add a News Post
			</h3>
			<div class="hidden">
				<form action='admin.php' method='post'>
					<h4>
						Title
					</h4>
					<p>
						<input type='text' class="text" name='newstitle' maxlength='50' size='50'/>
					</p>
					<h4>
						Content
					</h4>
					<p>
						<textarea name='content'></textarea>
					</p>
					<p>
						<input type='submit' class="button" value='Post News' name="postnews"/>
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
				<?
				$mysql = new mysqli($host, $username, $password, $database);

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
						<input type='submit' name="resetvotes" class="button" value='Reset Votes'/>
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
							echo "
									<div>
									<h4>
										$currevent[1]
										<div class = 'author'>
											$curreventd
											<div class='loctext'>Location: 
												$currevent[2]
											</div>
										</div>
									</h4>
									</div>";
									if ($_SESSION['isAdmin'] == 1) {
										echo "<form name='editevent' action='editevent.php' method='post'>
										<input type='submit' value='Edit' class = 'edit'>
										<input type='hidden' name='editid' value='$currevent[0]'>
										</form>";
									}
									echo "
									<img class = 'dispevpic' src = 'photos/".$curreventp[0]."'>";
							if (!($currevent[4] == null)) {
								echo "<div>RSVP'd: ".$currevent[4]."</div>";
							}
							else {
								echo "<div>No one is currently attending!</div>";
							}
						}
					}
					?>
			</div>
		</div>
	</div>
</div>
</body>
</html>