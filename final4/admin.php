<?
include_once('db.inc');
$con = mysql_connect($host,$username,$password);

if (!$con) {
    die('Could not connect: '. mysql_error());
	}
	
	mysql_select_db($database, $con);
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
	$newuser = $_POST['newuser'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
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
		mysql_query("DELETE FROM users WHERE username='".$rem[$i]."'");
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
</head>
<body>
	Welcome, <?php 
               		$un = $_SESSION['logged_user'];
               		$admin = mysql_query("SELECT isAdmin FROM users WHERE username='".$un."'");
               		$adminresult = mysql_fetch_row($admin);
               		if ($adminresult[0] == 1) {
						echo "<a href = admin.php><div class='user'><u>".$un."</u>!</div>";
					}
					else {
						echo "notadmin".$un."!";
					}

					?>
	<div class="header">
		<div class="center">
			<h4>
				ΦΣΣ
			</h4>
			<button class='login_button' onclick="$('#login').fadeToggle();">
				Login
			</button>
			<div id="login">
				<input class="textbox"/>
				<input class="textbox"/>
			</div>
		</div>
	</div>
	<div class="buffer"></div>
	<div class="center">
		<div class="blog"></div>
		<div class="nav">
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
						<div id ='right'>
							<p>
								<input type='submit' value='Create' class="button" onclick='return addcheck();'>
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
						<select name="albumid">
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
							echo "<input type='checkbox' name='rem[]' value='$adminarr[$i]' />$adminarr[$i]</p>";
						}
					?>
					<input type='hidden' name='remsub' value='1'>
					<input type='submit' value='Remove' onclick='return removecheck();' class="button">
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
						Album
					</h4>
					<p>
						<input type='text' class="text" name='blogtitle' maxlength='50' size='50'>
					</p>
					<p>
						<input type='hidden' name='author' value='<?php echo $_SESSION['logged_user']; ?>'>
					</p>
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
						<input type='submit' name="resetvotes" class="button" value='Reset Votes'>
					</p>
				</form> 
			</div>
		</div>
	</div>
</div>
</body>
</html>