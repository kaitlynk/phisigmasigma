<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="style.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Phi Sigma Sigma | Contact</title>
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
			<img src="images/contact.jpg" alt="home"/>
		</div>

	<div class="content">
		<h3>
			Contact
		</h3>
		<p>
			If you have any questions, comments, or concerns, please do not hesitate to reach out to us! 
		</p>
		<p>
			We would love to hear from you!
		</p>
		<h4>
			Email us at:
		</h4>
		<p>
			Mary Lopez, mel239@cornell.edu
			Renee Britton, rmb282@cornell.edu
		</p>
		<h4>
			Send us a letter at:
		</h4>
		<p>
			Phi Sigma Sigma
			14 South Avenue
			Ithaca, NY 14850
		</p>
		<div class="clear"></div>
	</div>
</body>
</html>