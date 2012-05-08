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
        <?php
                if (!isset($_SESSION['logged_user'])) {
                        $_SESSION['logged_user'] = $_POST['username'];
                }
        ?>

        <div class="center">
                <div class="ribbon">
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
			</div>
		</div>
        	<h1 id="ribbon_bottom" class="ribbon">
   				<strong class="ribbon-content">Phi Sigma Sigma</strong>
			</h1>
			<div class = 'module'>
            	<h2>
                	Dashboard
            	</h2>
           	<div id="events">
                        <h3>
                                Events
                        </h3>
                        <h4>
                                May 4, 2012 at 1:00pm
                        </h4>
                        <p>
                                Slope Day Party!
                        </p>
                        <h4>
                                May 5, 2012 at 1:00pm
                        </h4>
                        <p>
                                Day After Slope Day Party!
                        </p>
                </div>
           </div>
                <div class="module">
                        <h3>
                                Sister of the Month
                        </h3>
                        <p>
                                Submit your vote for sister of the month.
                                <!-- Connect to FinalProj database
                                Select name from choices
                                Radio button next to each name
                                If POST[choice] is set
                                        Update choices set pollid=pollid+1 where POST[choice]=name
                                        Select name, max(pollid) from choices
                                        Echo result -->
                        </p>
                </div>
                
                <!-- Notifications
                        Select type from notifications joins notificationsviewed
                        Echo result -->
        </div>
</body>
</html>

