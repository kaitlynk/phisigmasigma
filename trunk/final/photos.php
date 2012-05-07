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
		<!-- View Photos
			Connect to FinalProj Database
			Select path_small from photos
			Echo <a href=path_large><img href=path_small> -->
		
		<!-- Add Photos
			Connect to FinalProj Database
			Create path_small as scaled down version
			Insert into photos values(id, POST[caption], path_small, POST[path])
			Insert into photoInAlbum(id, POST[albums]) 
			Get currdate
			Insert into notifications(currdate, actionid, photos) 
			Update albums set datemodified=currdate where albumid=POST[albums]-->
		
		<!-- Add Album
			Connect to FinalProj Database
			Get currdate
			Insert into photos values(id, POST[title], currdate, currdate) -->

		</div>
	</div>

</body>
</html>