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
			<div class="title_pink">
				<h3>
					ALBUMS
				</h3>
			</div>
			<?
			$mysql = new mysqli($host, $username, $password, $database);
			$albums = $mysql->query("SELECT id,name FROM albums");
			while($album = $albums->fetch_assoc()) {
				echo '<div class="album_holder">';
				echo '<a href="album.php?id='.$album['id'].'">';
				$photos = $mysql->query("SELECT path_small FROM photos WHERE id IN (SELECT photoid FROM photoInAlbum WHERE albumid ='".$album['id']."') LIMIT 4");
				while($photo = $photos->fetch_assoc()) {
					echo '<img src="photos/'.$photo['path_small'].'" alt="image"/>';
				}
				if($photos->num_rows == 0) {
					echo '<img src="images/noimage.jpg" alt="image"/>';
				}
				$num = $mysql->query("SELECT COUNT(*) as num FROM photos WHERE id IN (SELECT photoid FROM photoInAlbum WHERE albumid ='".$album['id']."') LIMIT 4")->fetch_assoc();
				echo '</a>';
				echo '<span class="title">';
				echo htmlspecialchars($album['name']);
				echo '</span>';
				echo '<span class="count">';
				echo $num['num']." photos";
				echo '</span>';
				echo '</div>';
			}
			?>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>