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
<script type="text/javascript" src="phisigsig.js"></script>
</head>
<body>

        <?php
                $isright = false;
                if (!isset($_SESSION['logged_user'])) {
                        if (!isset($_POST['username'])) {
                        	echo "<div class='login'><div class='center'>";
                        }
                        else {
                                $user = strtolower($_POST['username']);
                                $con = mysql_connect("localhost","root","kkk524425kk");
                                if (!$con) {
                                        die('Could not connect: ' . mysql_error());
                                }
                                
                                mysql_select_db("test_Final_Project", $con);
                                
                                $users = mysql_query('SELECT* FROM users');
                                $numusers = mysql_num_rows($users);             
                                for ($i = 0; $i < $numusers; $i++) {
                                        $curruser = mysql_fetch_row($users);
                                        if ($user == strtolower($curruser[0]) && strcasecmp($_POST['pw'],$curruser[1]) == 0) {
                                                $_SESSION['logged_user'] = $_POST['username'];
                                                $isright = true;
                                        }
                                }
                                if (!$isright) {
                                	echo "<div class='login_show'><div class='center'><h6>The username/password combination you entered is incorrect.</h6>";
                                }
                                else {echo "<div class='login'><div class='center'>"; }
                        }
                }
                else { echo "<div class='login'><div class='center'>"; }
        ?>
                        <form name='login' action='index.php' method='post'>
                        <p>
                        	username
                        </p>
                        <input name="username" type="text" class="text"/>
                        <p>
                         	password
                        </p>
                        <input type="password" name="pw" class="text"/>
                        <br>
                        <input type='submit' value='Log In' onclick='return usercheck();'>
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
			<img src="images/home1.png" alt="home"/>
		</div>
        <div class="content">
                <div class="twitter">
                                <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
                                <script>
                                new TWTR.Widget({
                                  version: 2,
                                  type: 'profile',
                                  rpp: 2,
                                  interval: 30000,
                                  width: 230,
                                  height: 300,
                                  theme: {
                                    shell: {
                                      background: '#ccc',
                                      color: '#ffffff'
                                    },
                                    tweets: {
                                      background: '#ffffff',
                                      color: '#f3327f',
                                      links: '#0084b4'
                                    }
                                  },
                                  features: {
                                    scrollbar: false,
                                    loop: false,
                                    live: false,
                                    behavior: 'all'
                                  }
                                }).render().setUser('phisig_betaxi').start();
                                </script>
                        </div>
                <h3>
                        Recent Events
                        <?php echo $isright; ?>
                </h3>
                <h4>
                        Slope Day Party!
                </h4>
                <p>
                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi. 
                </p>
                <p>
                        id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.
                </p>
                <div class="clear"></div>
        </div>
</body>
</html>