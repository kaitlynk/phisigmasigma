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
			
			<?php
				$id = $_POST['editid'];
				$blogq = mysql_query("SELECT* FROM blogposts WHERE id='".$id."'");
				$blog = mysql_fetch_row($blogq);
			?>

			<form name='blog' action='blog.php' method='post'>
				<h5>
					Title: <input type='text' name='blogtitle' maxlength='50' size='50' value='<?php echo $blog[1]?>'><br><br>
					<input type='hidden' name='author' value='<?php echo $_SESSION['logged_user']; ?>'>
					<input type='hidden' name='editedid' value='<?php echo $blog[0]?>'>
					<input type='hidden' name='action' value='edit'>
					<div id ='center'><textarea name='content' rows='20' cols='107'><?php echo $blog[3]?></textarea></div><br>
					<div id ='right'><input type='submit' value='Post Blog' onclick='changevalue(edit);'>
					<input type='submit' value='Delete Blog' onclick='changevalue(delete);'></div>
				</h5>
			</form> 


</body>
</html>