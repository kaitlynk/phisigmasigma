<?php 
session_start();
/*
if (!isset($_SESSION['logged_user']))
	header("location: index.php");
	*/
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
</head>
<body>
	<?php
	/*
		if (!isset($_SESSION['logged_user'])) {
			$_SESSION['logged_user'] = $_POST['username'];
		}
		*/
	?>

	<div class="ribbon_loggedin">
		<div class="center">
			<ul>
				<li class="logo">ΦΣΣ</li>
				<li><a href="index.php">HOME</a></li>
				<li>EVENTS</li>
				<li>PHOTOS</li>
			</ul>

				<!-Welcome, <?php //echo $_SESSION['logged_user'];?>!-->
				<button class="login_button">
					<a href="logout.php">Logout</a>
				</button>
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
		<div class="module" id="events">
			<h3>
				Events
			</h3>
			<h4>
				May 4, 2012 at 1:00pm
			</h4>
			<p>
				Slope Day Party!
			</p>
			<h4>
				May 5, 2012 at 1:00pm
			</h4>
			<p>
				Day After Slope Day Party!
			</p>
		</div>
		<div class="module">
			<h3>
				Sister of the Month
			</h3>
			<p>
				Submit your vote for sister of the month.
			</p>
		</div>
	</div>
</body>
</html>