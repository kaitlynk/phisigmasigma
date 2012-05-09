<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="style.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Phi Sigma Sigma | History</title>
<script type="text/javascript" src="https://use.typekit.com/ahu5nxd.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="phisigsig.js"></script>
</head>
<body>
	<div class="login">
		<div class="center">
			<p>
				username
			</p>
			<input type="text" class="text"/>
			<p>
				password
			</p>
			<input type="text" class="text"/>
		</div>
	</div>
		<div class="center">
			<h1 class="ribbon">
				<strong class="ribbon-content">
					<ul>
						<a href='index.php'><li class="logo">ΦΣΣ</li></a>
                        	<?php if (isset($_SESSION['logged_user'])) {
                        		echo "<a href='dashboard.php'><li>HOME</li></a>"; } 
                        	?>
                            <a href="history.php"><li>HISTORY</li></a>
                            <?php if (isset($_SESSION['logged_user'])) {
                            	echo "<a href='events.php'><li>EVENTS</li></a>
                            	<a href='blog.php'><li>BLOGS</li></a>";}
                            ?>
                            <a href='photos.php'><li>PHOTOS</li></a>
                           	<a href="contact.php"><li>CONTACT</li></a>
                 	</ul>
         		</strong>
            	<?php
            		$con = mysql_connect("localhost","root","kkk524425kk");
                    	
						if (!$con) {
                       		die('Could not connect: '. mysql_error());
                   		}
                   		
                   		mysql_select_db("test_Final_Project", $con);
					if (isset($_SESSION['logged_user'])) {
                    	echo "<div class='user'>
                    	Welcome, ";
                    	                   		
               			$un = $_SESSION['logged_user'];
               			$admin = mysql_query("SELECT isAdmin FROM users WHERE username='".$un."'");
               			if (mysql_result($admin, 0) == 1) {
							echo "<a href = admin.php><div class='user'><u>".$un."</u>!</div>";
						}
						else {
							echo "<div class='user'>".$un."!</div>";
						}
						echo "<br>
                    	<div class='user'><a class='logout' href='logout.php'>Logout</a></div>";
                  	}       
            		else {
                 		echo "<button class='login_button' onclick=\"$('.login').slideToggle();\">
                		Login
               			</button>";
          			}
				?>
                        </h1>
					</ul>
					</strong>
			</h1>
			<h1 id="ribbon_bottom" class="ribbon">
   				<strong class="ribbon-content">Phi Sigma Sigma</strong>
			</h1>
			
			<!-- Adds blog posts -->
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
			
			<!-- Lists blogs -->
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
									
				
			<div class="module">
				<h3>
					This is a blog post title.
				</h3>
				<h4>
					May 4, 2012 at 1:00pm
				</h4>
				<p>
					This is filler text. This is where the content of the blog post will go. Below is video which can be embedded in a blog post.
				</p>
				<iframe width="420" height="315" src="http://www.youtube.com/embed/jYciRQDkYD4" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="module">
				<h3>
					This is another title.
				</h3>
				<h4>
					May 4, 2012 at 1:00pm
				</h4>
				<p>
					At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi.
				</p>
				<img src="http://namclo.linguistlist.org/images/Cornell3.jpg" alt="photo"/>
			</div>
		</div>
</body>
</html>