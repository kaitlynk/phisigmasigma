<?php
session_start();
include_once('db.inc');
$mysql = new mysqli($host, $username, $password, $database);

$con = mysql_connect($host,$username,$password);

if (!$con) {
    die('Could not connect: '. mysql_error());
	}
	
mysql_select_db($database, $con);

if(isset($_POST['vote'])) {
	$mysql->query("INSERT INTO votes(candidateid, voterid) VALUES(".$_POST['choice'].", 1)");
	$message = "<p>Your vote has been cast</p>";
}

if (isset($_POST['changeuser'])) {
	$changeuser = $_POST['changeuser'];     
	$oldun = $_SESSION['logged_user'];
                
	$users = mysql_query('SELECT username FROM users');
	$numusers = mysql_num_rows($users);
	$alreadyexists = false;
	for ($j = 0; $j < $numusers - 1; $j++) {
		$user = mysql_result($users, $j);
		if (strcasecmp($changeuser, $user) === 0) {
			$message = "The username \"".$changeuser."\" already exists. Please enter a different name.";
		}
		else {
			mysql_query("UPDATE users SET username='".$changeuser."' WHERE username='".$oldun."'");
			$_SESSION['logged_user'] = $changeuser;
			$message = "Your username has been successfully changed to ".$changeuser."!";
		}
	}
}
        	
if (isset($_POST['changepw'])) {
	$oldun = $_SESSION['logged_user'];	
	$changepw = md5($_POST['changepw']);     
	mysql_query("UPDATE users SET password='".$changepw."' WHERE username='".$oldun."'");
	$message = $message."<br>Your password has been successfully changed!";
}

if (isset($_POST['rsvp'])) {
	$rsvplist = $_POST['attev'];
	if (empty($rsvplist)) {
		$message = "<p>You did not select any events. Please try again.</p>";
	}
	else {
		$numrsvp = count($rsvplist);
		for ($i = 0; $i < $numrsvp; $i++) {
			$un = $_SESSION['logged_user'];	
			$rsvpeventq = mysql_query("SELECT Attendees FROM events WHERE id='".$rsvplist[$i]."'");
			$rsvpevent = mysql_fetch_row($rsvpeventq);
			$rsvpnameq = mysql_query("SELECT firstname, lastname FROM users WHERE username='".$un."'");
			$rsvpname = mysql_fetch_row($rsvpnameq);
			if ($rsvpevent[0] == "") {
				$rsvpevent[0] = $rsvpname[0]." ".$rsvpname[1];
			}
			else {
				$rsvpevent[0] = $rsvpevent[0].", ".$rsvpname[0]." ".$rsvpname[1];
			}
			$rsvpsucc = mysql_query("UPDATE events SET Attendees='".$rsvpevent[0]."' WHERE id='".$rsvplist[$i]."'");
			$message = "<p>Successfully RSVP'd.</p>";
			if (!$rsvpsucc) {
    			die('Invalid query: ' . mysql_error());
				$message = "<p>You could not RSVP to the events. Please try again.</p>";
			}
		}
	}
}

if (isset($_POST['unrsvp'])) {
	$rsvplist = $_POST['attev'];
	if (empty($rsvplist)) {
		$message = "<p>You did not select any events. Please try again.</p>";
	}
	else {
		$numrsvp = count($rsvplist);
		for ($i = 0; $i < $numrsvp; $i++) {
			$un = $_SESSION['logged_user'];	
			$rsvpeventq = mysql_query("SELECT Attendees FROM events WHERE id='".$rsvplist[$i]."'");
			$rsvpevent = mysql_fetch_row($rsvpeventq);
			
			$rsvpnameq = mysql_query("SELECT firstname, lastname FROM users WHERE username='".$un."'");
			$rsvpname = mysql_fetch_row($rsvpnameq);
			$rsvper = $rsvpname[0]." ".$rsvpname[1];
			
			$rsvparray = explode(", ", $rsvpevent[0]);
			$isrsvp = false;
			
			for ($i = 0; $i < count($rsvparray); $i++) {
			echo $rsvparray[$i];
				if (strcasecmp($rsvper, $rsvparray[$i]) === 0) {
					echo strcasecmp($rsvper, $rsvparray[$i]);
					$rsvparray = array_splice($rsvparray, $i);
					$isrsvp = true;
				}
			}
		}
		if ($isrsvp) {
			$newrsvp = implode(", ", $rsvparray);
			echo $newrsvp;
			$rsvpsucc = mysql_query("UPDATE events SET Attendees='".$newrsvp."' WHERE id='".$rsvplist[$i]."'");
			$message = "<p>Successfully unRSVP'd.</p>";
		}
			
		else {
			$message = "<p>You did not RSVP for this event previously. Please try again.</p>";
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="style.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery.noty.css"/>
<link rel="stylesheet" type="text/css" href="css/noty_theme_default.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Phi Sigma Sigma</title>
<script type="text/javascript" src="https://use.typekit.com/ahu5nxd.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
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
	<div class="center_module">
		<div class="module">
			<h3 onclick="$(this).next('.hidden').slideToggle(200)">
				Upcoming Events
			</h3>
			<div class="hidden">
				<?php
					
					$alleventsq = mysql_query('SELECT* FROM events ORDER BY datetime LIMIT 10');
					if (!$alleventsq) {
    					die('Invalid query: ' . mysql_error());
					}
					$numevents = mysql_num_rows($alleventsq);
					if ($numevents == 0) {
						echo "There are currently no events scheduled!";
					}
					else {
						echo "<form name='attendingeve' action='dashboard.php' method='post'>";
							for ($i = 0; $i < $numevents; $i++) {
								$currevent = mysql_fetch_row($alleventsq);
								$curreventq = date_create($currevent[3]);
								$curreventd = date_format($curreventq, 'l, F j, Y @ g:ia');
								echo "<div class = 'module'>
										<div class='eventstitle'>
											<input type='checkbox' name='attev[]' value='$currevent[0]' />&nbsp;$currevent[1]
											<div class = 'author'> 
												$curreventd
											</div>
										</div>
										</h3>
											<h4 class='loctext'>
												$currevent[2]
											</h4>";
								if (!($currevent[4] == null)) {
									echo "<p class='blogtext'>".$currevent[4]."</p>
									</div>";
								}
								else {
									echo "<p class='blogtext'>No one is currently attending!</p>
									</div>";
								}
							}
						echo "<div id ='right'>
						<input type='submit' class='button' name='unrsvp' value='unRSVP'>
						<input type='submit' class='button' name='rsvp' value='RSVP'>
						</div>
						</form>";
					}
				?>
			</div>
		</div>
	</div>
	<div class="center_module">
		<div class="module">
			<h3 onclick="$(this).next('.hidden').slideToggle(200)">
				Vote for Sister of the Month
			</h3>
			<div class="hidden">
				<form method="post" action="dashboard.php">
					<?
					$choices = $mysql->query("SELECT username,id FROM users ORDER BY username");
					while($choice = $choices->fetch_assoc()) {
						echo '<p><input type="radio" name="choice" value="'.$choice['id'].'">'.$choice['username'].'</p>';
					}
					?>
					<p>
						<input type="submit" name="vote" value="Vote" class="button"/>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>