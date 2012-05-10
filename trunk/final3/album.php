<?
include_once('db.inc');
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
	<div class="header">
		<div class="center">
			<h4>
				ΦΣΣ
			</h4>
			<button class='login_button' onclick=\"$('.login').slideToggle();\">
				Login
			</button>
		</div>
	</div>
	<div class="buffer"></div>
	<div class="center">
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
	<div class="center">
		<div class="content">
			<div class="title_pink">
				<h3>
					ALBUMS
				</h3>
			</div>
			<?
			$mysql = new mysqli($host, $username, $password, $database);
			$photos = $mysql->query("SELECT photoid,path_small,caption FROM photoInAlbum JOIN photos ON(photoInAlbum.photoid = photos.id) WHERE albumid = $_GET[id] ORDER BY photoid");
			while($photo = $photos->fetch_assoc()) {
				echo '<a class="photo_holder" href="photo.php?album&#61;'.$_GET['id'].'&amp;photo='.$photo['photoid'].'">';
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