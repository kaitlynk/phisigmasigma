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
			<h1 class="ribbon">
				<strong class="ribbon-content">
					<ul>
						<a href="index.php"><li class="logo">ΦΣΣ</li></a>
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
                    	<div class='user'><a class='logout' href='logout.php'>Logout</a></div>";
                  	}       
            		else {
                 		echo "<button class='login_button' onclick=\"$('.login').slideToggle();\">
                		Login
               			</button>";
          			}
				?>
			</h1>
			<h1 id="ribbon_bottom" class="ribbon">
   				<strong class="ribbon-content">Phi Sigma Sigma</strong>
			</h1>
			<img src="images/history.jpg" alt="home"/>
		</div>

	<div class="content">
		<h3>
			History
		</h3>
		<h4>
			Local Beta Xi Chapter History
		</h4>
		<p>
			The Beta Xi Chapter was originally founded on October 2, 1954, and then closed in the late 1960s due
			to an overall decline in Greek Life on college campuses at the time. In the Fall of 2010 Cornell University
			opened for expansion, meaning to bring another sorority to campus, and Phi Sigma Sigma was chosen
			unanimously by the University's Panhellenic members to join Cornell's Greek Community once again
			as the twelfth sorority on campus. The chapter re-colonized in the Fall of 2011 and celebrated Re-
			Installation as a Phi Sigma Sigma Chapter and the Initiation of 95 Founding Sisters on November 19,
			2011.
		</p>
		<h4>
			International History
		</h4>
		<p>
			Phi Sigma Sigma is internationally known as a successful philanthropic and social society, with over
			60,000 women as members. Founded on November 26, 1913 at Hunter College, Phi Sigma Sigma was
			the first nonsectarian sorority. The fraternity now has 110 active collegiate chapters throughout the
			United States and Canada.
		</p>
		<div class="clear"></div>
	</div>
</body>
</html>