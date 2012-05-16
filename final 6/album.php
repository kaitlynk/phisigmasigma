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
			$mysql = new mysqli($host, $username, $password, $database);
			$name = $mysql->query("SELECT name FROM albums WHERE id=".$_GET['id']);
			$name = $name->fetch_assoc();
			echo '<div class="title_pink">
				<h3>'.
					$name['name'].'
				</h3>
				</div>';
			$photos = $mysql->query("SELECT id,path_small,caption FROM photoInAlbum JOIN photos ON(photoInAlbum.photoid = photos.id) WHERE albumid = $_GET[id] ORDER BY photoid");
			while($photo = $photos->fetch_assoc()) {
				echo '<a class="photo_holder" href="photo.php?id='.$photo['id'].'">';
				echo '<img src="photos/'.$photo['path_small'].'" alt="image"/>';
				echo '<span class="title">';
				echo htmlspecialchars($photo['caption']);
				echo '</span>';
				echo '</a>';
			}
			?>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>