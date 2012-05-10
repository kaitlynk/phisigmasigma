
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
	Welcome, <?php 
	include_once('db.inc');
					$con = mysql_connect($host,$username,$password);
					
					if (!$con) {
                        die('Could not connect: '. mysql_error());
                   	}
                   	
               		mysql_select_db($database, $con);
               		$un = $_SESSION['logged_user'];
               		$admin = mysql_query("SELECT isAdmin FROM users WHERE username='".$un."'");
               		if (mysql_result($admin, 0) == 1) {
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
		<?php
				if (isset($_POST['blogtitle']) && isset($_POST['content'])) {
					$title=$_POST['blogtitle'];
					$content=$_POST['content'];
					date_default_timezone_set("America/New_York");
					$date = date('Y-m-d H:i:s');
					$author=$_POST['author'];
					if (isset($_POST['editedid'])) {
						$editedid = $_POST['editedid'];
						if ($_POST['action'] == 'edit') {
							mysql_query("UPDATE blogposts SET title='".$title."', content='".$content."', datemodified='".$date."' 
							WHERE id='".$editedid."'");
						}
						else if ($_POST['action'] == 'delete') {
							mysql_query("DELETE FROM blogposts WHERE id='".$editedid."'");
						}
					}
					else {
						mysql_query("INSERT INTO blogposts (title, author, content, datecreated, datemodified) 
						VALUES ('".$title."', '".$author."', '".$content."', '".$date."', '".$date."')");
					}
				}
			?>
			<?php
				$numblogsquery = mysql_query("SELECT MAX(id) FROM blogposts");
				$numblogs = mysql_fetch_row($numblogsquery);
				for ($i = $numblogs[0]; $i > 1; $i--) {
					$blogquery = mysql_query("SELECT* FROM blogposts WHERE id='".$i."'");
					$blog = mysql_fetch_row($blogquery);
					if (!blogquery || $blog[1] == "") {
					}
					else {
						$datecq = date_create($blog[4]);
						$datemq = date_create($blog[5]);
						$datec = date_format($datecq, 'l, F j, Y \a\t g:ia');
						$datem = date_format($datemq, 'l, F j, Y \a\t g:ia');
						
						echo "<div class='module'>
								<h3> $blog[1] <div id = 'author'> by $blog[2] </div>";
						if (mysql_result($admin, 0) == 1) {
						echo "<form name='editblog' action='editblog.php' method='post'>
						<input type='submit' value='Edit' class = 'edit'>
						<input type='hidden' name='editid' value='$blog[0]'>
						</form>";
						}
						echo "</h3>
								<h4>".$datec."</h4>
								<p>".$blog[3]."</p>
							</div>";
					}
				}
			?>
	<div class="center_module">
		<div class="module">
			<div class="title_pink">
				<h3>
					This is a blog title
				</h3>
			</div>
			<p>
				This is some blog content.
			</p>
		</div>
	</div>
</body>
</html>