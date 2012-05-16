<?php session_start();
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
<script type="text/javascript" src="phisigsig.js"></script>
</head>
<body>
	<?
	include('header.php');
	?>
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="center_module">
		<?php
				if (isset($_POST['blogtitle']) && isset($_POST['content'])) {
					$title=$mysql->real_escape_string($_POST['blogtitle']);
					$content=$mysql->real_escape_string($_POST['content']);
					date_default_timezone_set("America/New_York");
					$date = date('Y-m-d H:i:s');
					$author=$mysql->real_escape_string($_POST['author']);
					if (isset($_POST['editedid'])) {
						$editedid = $_POST['editedid'];
						if ($_POST['action'] == 'edit') {
							$mysql->query("UPDATE blogposts SET title='".$title."', content='".$content."', datemodified='".$date."' 
							WHERE id='".$editedid."'");
						}
						else if ($_POST['action'] == 'delete') {
							$mysql->query("DELETE FROM blogposts WHERE id='".$editedid."'");
						}
					}
					else {
						$mysql->query("INSERT INTO blogposts (title, author, content, datecreated, datemodified) 
						VALUES ('".$title."', '".$author."', '".$content."', '".$date."', '".$date."')");
						$mysql->query("INSERT INTO notifications(datetime, actionid, type) VALUES(NOW(), LAST_INSERT_ID(), 'blog')");
					}
				}
			?>
			<?php
				$numblogsquery = $mysql->query("SELECT MAX(id) FROM blogposts");
				$numblogs = $numblogsquery->fetch_row();
				for ($i = $numblogs[0]; $i > 1; $i--) {
					$blogquery = $mysql->query("SELECT* FROM blogposts WHERE id='".$i."'");
					$blog = $blogquery->fetch_row();
					if (!$blogquery || $blog[1] == "") {
					}
					else {
						$datecq = date_create($blog[4]);
						$datemq = date_create($blog[5]);
						$datec = date_format($datecq, 'l, F j, Y \a\t g:ia');
						$datem = date_format($datemq, 'l, F j, Y \a\t g:ia');
						$namequery = $mysql->query("SELECT firstname,lastname FROM users WHERE username='".$blog[2]."'");
						$namearray = $namequery->fetch_row();
						$name = $namearray[0]." ".$namearray[1];
						
						echo "<div class='content'>
									<div class='blogtitle'><h3>
											$blog[1]</h3>									</div>";
						if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
							echo "<form name='editblog' action='editblog.php' method='post'>
								<input type='submit' value='Edit' class = 'edit'>
								<input type='hidden' name='editid' value='$blog[0]'>
							</form>";
						}

						
						echo "</h3>
								<h4 class='date'>".$datec."</h4>
								<p>".$blog[3]."</p>
								<p> Posted by $name </p>
							</div>";
					}
				}
			?>

		</div>
	</div>
</body>
</html>