<?
$mysql = new mysqli($host, $username, $password, $database);
                if (!isset($_SESSION['logged_user'])) {
                        if(isset($_POST['login'])) {
                                $user = strtolower($_POST['username']);
                                $pw = md5($_POST['pw']);  
                                $con = mysql_connect($host,$username,$password);
                                if (!$con) {
                                    die('Could not connect: ' . mysql_error());
                                }
                                
                                mysql_select_db($database, $con);
                                
                                $users = $mysql->query("SELECT * FROM users WHERE username = '".$user."' AND password ='".$pw."'");
                                $numusers = $users->num_rows;        
                                if($numusers == 1) {
                                	$users = $users->fetch_assoc();
                                    $_SESSION['logged_user'] = $user;
                                    if($users['isAdmin'] == 1) {
                                    	$_SESSION['isAdmin'] = 1;
                                    	header('location: admin.php');
                                    }
                                    else {
                                    	$_SESSION['isAdmin'] = 0;
                                    	header('location: dashboard.php');
                                    }
                                }
                                else {
                                	$errortext = '<div class="error"><p>The username/password combination you entered is incorrect.</p></div>';
                                }
                        }
                }
    ?>
    <div class="new_notification">
    	<div class="notification_center"></div>
    </div>
	<div class="header">
		<div class="center">
			<h4>
				<?
				if(!isset($_SESSION['logged_user'])) {
					echo '<a href="index.php">
						ΦΣΣ
						</a>';
				}
				elseif($_SESSION['isAdmin'] == 1) {
					echo '<a href="admin.php">
						ΦΣΣ
						</a>';
				}
				elseif($_SESSION['isAdmin'] == 0) {
					echo '<a href="dashboard.php">
						ΦΣΣ
						</a>';
				}
				?>
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
			<?
			if(isset($_SESSION['logged_user'])) {
				$result = $mysql->query("SELECT COUNT(*) as num FROM notifications WHERE datetime > (SELECT lastViewed FROM notificationsViewed WHERE username ='".$_SESSION['logged_user']."') LIMIT 1");
				$result = $result->fetch_assoc();
				$num = $result['num'];
				echo '<button class="'.($num == 0 ? "notification_count" : "notification_count_new").'" onclick="$(\'#notifications\').slideToggle(200);$.post(\'resetnotifications.php\');$(this).html(\'0\').removeClass(\'notification_count_new\').addClass(\'notification_count\');">'.$num.'</button>';
			}
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
		else {
			echo '<div id="notifications">';
			$notifications = $mysql->query("SELECT * FROM notifications ORDER BY datetime DESC LIMIT 5");
			while($notification = $notifications->fetch_assoc()) {
				$type = $notification['type'];
				$phptime = strtotime( $notification['datetime'] );
				$time = date( 'F d g:ia', $phptime );
				if($type == 'photo') {
					echo '<p>A new <a href="photo.php?id='.$notification['actionid'].'">photo</a> was added</p><p class="time">'.$time.'</p>';
				}
				elseif($type == 'album') {
					echo '<p>A new <a href="album.php?id='.$notification['actionid'].'">album</a> was added</p><p class="time">'.$time.'</p>';
				}
				elseif($type == 'blog') {
					echo '<p>A new <a href="blog.php">blog</a> post was added</p><p class="time">'.$time.'</p>';
				}
				elseif($type == 'event') {
					echo '<p>A new <a href="event.php?id='.$notification['actionid'].'">event</a> was added</p><p class="time">'.$time.'</p>';
				}
			}
			echo '</div>';
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
					<a href="about.php">About</a>
				</li>
				<li>
					<a href="contact.php">Contact</a>
				</li>
				<li>
					<a href="albums.php">Photos</a>
				</li>
				<li>
					<a href="blog.php">Blog</a>
				</li>
			</ul>

		</div>
	</div>