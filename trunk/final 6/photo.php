<?
session_start();
include_once('db.inc');
$mysql = new mysqli($host, $username, $password, $database);
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
<script type="text/javascript" src="notify.js"></script>
</head>
<body>
	<?
		include('header.php');
	?>
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="center_module">
		<div class="content">
			<?
			$photo = $mysql->query("SELECT caption, path_large FROM photos WHERE id=$_GET[id]");
			$photo = $photo->fetch_assoc();
			echo '<div class="photo_large"><img src="photos/'.$photo['path_large'].'" alt="image"/></div>';
			echo '<div class="side"><h3>Caption: '.htmlspecialchars($photo['caption']).'</h3></div>';
			?>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>