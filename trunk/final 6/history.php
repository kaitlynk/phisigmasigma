<? 
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
	<?
	 $isright = false;
                if (!isset($_SESSION['logged_user'])) {
                        if(isset($_POST['login'])) {
                                $user = strtolower($_POST['username']);
                                $con = mysql_connect($host,$username,$password);
                                if (!$con) {
                                    die('Could not connect: ' . mysql_error());
                                }
                                
                                mysql_select_db($database, $con);
                                
                                $users = mysql_query('SELECT* FROM users');
                                $numusers = mysql_num_rows($users);        
                                $pw = md5($_POST['pw']);     
                                for ($i = 0; $i < $numusers; $i++) {
                                        $curruser = mysql_fetch_row($users);
                                        if ($user == strtolower($curruser[1]) && strcasecmp($pw,$curruser[4]) == 0) {
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
			<?
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
		<?
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
				<li>
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="history.php">History</a>
				</li>
				<li>
					<a href="contact.php">Contact</a>
				</li>
				<li>
					<a href="blog.php"><button>Blog</button></a>
				</li>
			</ul>

		</div>
		<img src="images/contact.jpg" alt="contact"/>
	</div>
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="center">
		<div class="nav_side">
			<ul>
				<li id="current" class="ribbon" onclick="$('.content_bottom').children().fadeOut(100);$('#history').fadeIn(100);$(this).attr('id','current').siblings().removeAttr('id')">
					<strong class="ribbon-content">
						History
					</strong>
				</li>
				<li class="ribbon" onclick="$('.content_bottom').children().fadeOut(100);$('#sisterhood').fadeIn(100);$(this).attr('id','current').siblings().removeAttr('id')">
					<strong class="ribbon-content">
						Sisterhood
					</strong>
				</li>
				<li class="ribbon" onclick="$('.content_bottom').children().fadeOut(100);$('#philantropy').fadeIn(100);$(this).attr('id','current').siblings().removeAttr('id')">
					<strong class="ribbon-content">
						Philantropy
					</strong>
				</li>
			</ul>
		</div>
		<div class="content_bottom">
			<div id="history">
				<h3>
					Local Beta Xi Chapter History
				</h3>
				<p>
					The Beta Xi Chapter was originally founded on October 2, 1954, and then closed in the late 1960s due
					to an overall decline in Greek Life on college campuses at the time. In the Fall of 2010 Cornell University
					opened for expansion, meaning to bring another sorority to campus, and Phi Sigma Sigma was chosen
					unanimously by the University's Panhellenic members to join Cornell's Greek Community once again
					as the twelfth sorority on campus. The chapter re-colonized in the Fall of 2011 and celebrated Re-
					Installation as a Phi Sigma Sigma Chapter and the Initiation of 95 Founding Sisters on November 19,
					2011.
				</p>
				<h3>
					International History
				</h3>
				<p>
					Phi Sigma Sigma is internationally known as a successful philanthropic and social society, with over
					60,000 women as members. Founded on November 26, 1913 at Hunter College, Phi Sigma Sigma was
					the first nonsectarian sorority. The fraternity now has 110 active collegiate chapters throughout the
					United States and Canada.
				</p>
			</div>
			<div id="sisterhood">
				<h3>
					SISTERHOOD
				</h3>
				<p>
					Our sisterhood at Phi Sigma Sigma’s Beta Xi chapter is made up of strong, dynamic women who are
					extremely involved on campus, in Greek life, and within the surrounding community. We have strong
					bonds with our sisters and participate in many sisterhood activities and events to bring us closer and
					have fun with each other! Some of our events include sisterhood dinners, exercise classes, social events,
					retreats, and many more. We have a very strong sisterhood and look forward to the countless events in
					the near future to keep it this way! Go to the “Contact” page to reach out and learn more about what
					being a Phi Sig means!
				</p>
			</div>
			<div id="philantropy">
				<h3>
					PHILANTHROPY
				</h3>
				<p>
					Internationally, we support the Phi Sigma Sigma Foundation. The foundation raises funds from all
					Phi Sigma Sigma chapters which then go towards The National Kidney Foundation and our own Twin
					Ideals Fund. The Twin Ideals Fund sends aid to natural disaster victims, such as those in Louisiana
					after Hurricane Katrina. The Foundation also awards scholarships, funds leadership programming, and
					provides resources for philanthropic events.

					Our main philanthropy event is the Phi Sigma Sigma Golf Outing, which is held in the spring, and all
					proceeds go to the Phi Sigma Sigma Foundation. It is a great event that many sisters’ parents, friends,

					and families come out to support and participate in. We also organize a luncheon following the event
					with a raffle and many other prizes and giveaways. The next Golf Outing is in planning as soon as the
					one before is over and pays off in the end!
				</p>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</body>
</html>