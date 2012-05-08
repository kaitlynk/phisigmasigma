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
	<div class="login">
		<div class="center">
        	<form id='login' action='index.php' method='post'>
        		<p>
            		username
        		</p>
       			<input name="username" type="text" class="text"/>
          		<p>
          			password
        		</p>
         		<input type="password" name="pw" class="text"/>
           		<br>
        		<input type='submit' value='Log In' action='usercheck();'>
          	</form>
            <br>
		</div>
	</div>

	<div class="center">
		<div class="ribbon">
			<strong class="ribbon-content">
				<ul>
					<a href='index.php'><li class="logo">ΦΣΣ</li></a>
					<?php 
						if (isset($_SESSION['logged_user'])) {
                    		echo "<a href='dashboard.php'><li>HOME</li></a>"; 
                    	} 
                	?>
                	<a href="history.php"><li>HISTORY</li></a>
                	<?php 
                   		if (isset($_SESSION['logged_user'])) {
               				echo "<a href='events.php'><li>EVENTS</li></a>
                    		<a href='blog.php'><li>BLOGS</li></a>";
                    	}
               		?>
                	<a href='photos.php'><li>PHOTOS</li></a>
               		<a href="contact.php"><li>CONTACT</li></a>
				</ul>
			</strong>
				<?php
					if (isset($_SESSION['logged_user'])) {
                    	echo "<div class='user'>
                    	Welcome, ";
                    	
                    	$con = mysql_connect("localhost","root","kkk524425kk");
                    	
						if (!$con) {
                       		die('Could not connect: '. mysql_error());
                   		}
                   		
                   		mysql_select_db("test_Final_Project", $con);
                   		
               			$un = $_SESSION['logged_user'];
               			$admin = mysql_query("SELECT isAdmin FROM users WHERE username='".$un."'");
               			if (mysql_result($admin, 0) == 1) {
							echo "<a href = admin.php><div class='user'><u>".$un."</u>!</div>";
						}
						else {
							echo $un."!";
						}
						echo "<br>
                    	<div class='user'><a class='logout' href='logout.php'>Logout</a></div></div>";
                  	}       
            		else {
                 		echo "<button class='login_button' onclick=\"$('.login').slideToggle();\">
                		Login
               			</button>";
          			}
				?>
		</div>
		<h1 id="ribbon_bottom" class="ribbon">
   				<strong class="ribbon-content">Phi Sigma Sigma</strong>
		</h1>
		<div class="module">
			<h2>
				Albums
			</h2>
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