<?php
session_start();
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
<script type="text/javascript" src="jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="jquery.smoothDivScroll-1.2.js"></script>
<script type="text/javascript" src="phisigsig.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#makeMeScrollable").smoothDivScroll({ 
			mousewheelScrolling: true,
			manualContinuousScrolling: true,
			visibleHotSpotBackgrounds: "always",
			autoScrollingMode: "onstart"
		});
		$(function() {
            $('#makeMeScrollable').each(function() {
                $('img').hover(
                    function() {
                        $(this).stop().animate({ opacity: 1.0 }, 400);
                    },
                   function() {
                       $(this).stop().animate({ opacity: 0.9 }, 400);
                   })
                });
        });
	});

</script>
</head>
<body>
	<?php
	 $isright = false;
                if (!isset($_SESSION['logged_user'])) {
                        if(isset($_POST['login'])) {
                                $user = strtolower($_POST['username']);
                                $con = mysql_connect($host,$username,$password);
                                if (!$con) {
                                    die('Could not connect: ' . mysql_error());
                                }
                                
                                mysql_select_db("test_Final_Project", $con);
                                $users = mysql_query('SELECT* FROM users');
                                $numusers = mysql_num_rows($users);        
                                $pw = md5($_POST['pw']);
                                for ($i = 0; $i < $numusers; $i++) {
                                        $curruser = mysql_fetch_row($users);
                                        if (strcasecmp($user, $curruser[1]) === 0 && strcasecmp($pw,$curruser[4]) === 0) {
                                                $_SESSION['logged_user'] = $_POST['username'];
                                                $isright = true;
                                        }
                                }
                                if (!$isright) {
                                	$errortext = '<div class="error"><p>The username/password combination you entered is incorrect.</p></div>';
                                }
                        }
                }                
    ?>
	<div class="header">
		<div class="center">
			<h4>
				ΦΣΣ
			</h4>
			<?php
			if(!isset($_SESSION['logged_user'])) {
				echo '<button class="login_button" onclick="$(\'#login\').slideToggle(100);">
					Login
					</button>';
			}
			else {
				echo '<a href="logout.php" class="login_button">
					Logout
					</a>';
			}
			if(isset($errortext))
				echo $errortext;
			?>
		</div>
	</div>
	<div class="buffer"></div>
	<div class="center">
		<div class="blog"></div>
		<div class="nav">
		<?php
		if(!isset($_SESSION['logged_user'])) {
			echo '<div id="login">
				<form name="login" action="index.php" method="post">
                <input name="username" type="text" class="text"/>
                <input type="password" name="pw" class="text"/>
                <input type="submit" name="login" class="login_button"/>
           		</form>
				</div>';
		}
		?>
		<h1>
			Phi Sigma Sigma.
		</h1>
			<ul>
				<a href = 'index.php'><li>
					Home
				</li></a>
				<a href = 'history.php'><li>
					History
				</li></a>
				<a href = 'contact.php'><li>
					Contact
				</li></a>
				<a href = 'blog.php'><li>
					<button>Blog</button>
				</li></a>
			</ul>

		</div>
	<div id="makeMeScrollable">
		<img src="images/contact.jpg" alt="Demo image" id="field" />
		<img src="images/home1.png" alt="Demo image" id="field" />
		<img src="images/contact.jpg" alt="Demo image" id="field" />
	</div>
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="center">
		<div class="nav_side">
			<ul>
				<li id="current" class="ribbon">
					<strong class="ribbon-content">
					Recent Activity
					</strong>
				</li>
				<li class="ribbon">
					<strong class="ribbon-content">
					News
					</strong>
				</li>
			</ul>
		</div>
		<div class="content_bottom">
			<h2>
				This is a title.
			</h2>
			<p>
				hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello 
			</p>
			<div class="twitter">
				<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js" type="text/javascript"></script>
				<script type="text/javascript">
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
		</div>
		<div class="clear"></div>
	</div>
</body>
</html>