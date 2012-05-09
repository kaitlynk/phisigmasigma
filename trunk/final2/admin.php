
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
</head>
<body>
	Welcome, <?php 
	include_once('db.inc');
					$con = mysql_connect($host,$username,$password);
					
					if (!$con) {
                        die('Could not connect: '. mysql_error());
                   	}
                   	
               		mysql_select_db($database, $con);
               		$un = $_SESSION['logged_user'];
               		$admin = mysql_query("SELECT isAdmin FROM users WHERE username='".$un."'");
               		$adminresult = mysql_fetch_row($admin);
               		if ($adminresult[0] == 1) {
						echo "<a href = admin.php><div class='user'><u>".$un."</u>!</div>";
					}
					else {
						echo "notadmin".$un."!";
					}
					?>
	<div class="header">
		<div class="center">
			<h4>
				ΦΣΣ
			</h4>
			<button class='login_button' onclick="$('#login').fadeToggle();">
				Login
			</button>
			<div id="login">
				<input class="textbox"/>
				<input class="textbox"/>
			</div>
		</div>
	</div>
	<div class="buffer"></div>
	<div class="center">
		<div class="blog"></div>
		<div class="nav">
		<h1>
			Phi Sigma Sigma.
		</h1>
			<ul>
				<li>
					Home
				</li>
				<li>
					History
				</li>
				<li>
					Contact
				</li>
				<li>
					<button>Blog</button>
				</li>
			</ul>

		</div>
	</div>
	<div class="pink"></div>
	<div class="blue"></div>
			<?php
				if (isset($_POST['newuser']) && isset($_POST['newpw'])) {
             		$newuser = $_POST['newuser'];
               		$newpw = md5($_POST['newpw']);
               		$users = mysql_query('SELECT username FROM users');
               		$numusers = mysql_num_rows($users);
               		$alreadyexists = false;
               		for ($j = 0; $j < $numusers - 1; $j++) {
						$user = mysql_result($users, $j);
						if (strcasecmp($newuser, $user) === 0) {
							$alreadyexists = true;
						}
					}
					if ($alreadyexists) {
						echo "<h5><font color = 'red'>ERROR: The username \"".$newuser."\" already exists. Please enter a different name.</font></h5>";
					}
	               	else if (isset($_POST['isadmin'])) {
	                   	mysql_query('INSERT INTO users VALUES(\''.$newuser.'\', \''.$newpw.'\', 1)');
	                    echo "<h5>Successfully added administrator \"".$newuser."\" to the site.</h5>";
	              	}
	                else {
	                    mysql_query('INSERT INTO users VALUES(\''.$newuser.'\', \''.$newpw.'\', 0)');
	                    echo "<h5>Successfully added user \"".$newuser."\" to the site.</h5>";
	                }
	            }
	     	?>
	     	
		  	<?php
		  		if (isset($_POST['remsub'])) {
		        	$rem = $_POST['rem'];
		        	if (empty($rem)) {
		        		echo "<h5><font color = 'red'>Please select users to delete.</font></h5>";
		        	}
		        	else {
		        		$numrem = count($rem);
		        		for ($i = 0; $i < $numrem; $i++) {
		        			mysql_query("DELETE FROM users WHERE username='".$rem[$i]."'");
		        		}
		        		echo "<h5>Successfully deleted users.</h5>";
		        	}
		        }
	        ?>
	        <?
	        if(isset($_POST['submit'])) {
	        	mysql_query("INSERT INTO albums(name, datecreated) VALUES('".$_POST['name']."', CURDATE())");
	        }
	        ?>
	        <div class="center_module">
	        <div class="module">
	        <form name='adduser' action='admin.php' method='post'>
				<table>
				<tr>
					<td>Username: 
					<td><input type='text' name='newuser'/>
				</tr>
				<tr>
					<td>Password: 
					<td><input type='text' name='newpw'/>
				</tr>
				</table>
				&nbsp;&nbsp;<input type='checkbox' name='isadmin' value='isadmin'/> Administrator <br>
				<div id ='right'><input type='submit' value='Create' onclick='return addcheck();'></div>
				</form>
			</div>
		</div>
				<div class="center_module">
					<div class="module">
				<form name='removeuser' action='admin.php' method='post'>
         		<?php
         			$usersarr = array();
       				$adminarr = array();
               		$users = mysql_query('SELECT* FROM users');
               		$numusers = mysql_num_rows($users);
               		for ($j = 0; $j < $numusers; $j++) {
						$user = mysql_fetch_row($users);
						if ($user[2] == 0) {
							array_push($usersarr,$user[0]);
						}
						else {
							array_push($adminarr,$user[0]);
						}
					}
					echo "<table width='100%'><tr><td class='dashboard'><b>Users</b><br>";
					for ($i = 0; $i < count($usersarr); $i++) {
						echo "<input type='checkbox' name='rem[]' value='$usersarr[$i]' />&nbsp;$usersarr[$i]<br>";
					}
					echo "<td class='dashboard'><b>Administrators</b><br>";
					for ($i = 0; $i < count($adminarr); $i++) {
						echo "<input type='checkbox' name='rem[]' value='$adminarr[$i]' />&nbsp;$adminarr[$i]<br>";
					}
					echo "</tr></table>";
				?>
				<br>
				<input type='hidden' name='remsub' value='1'>
				<input type='submit' value='Remove' onclick='return removecheck();'>
			</form>
		</div>
	</div>
		</div>
	</div>
	<div class="center_module">
		<div class="module">
			<form name='blog' action='blog.php' method='post'>
					<h5>
						Title: <input type='text' name='blogtitle' maxlength='50' size='50'><br><br>
						<input type='hidden' name='author' value='<?php echo $_SESSION['logged_user']; ?>'>
						<div id ='center'><textarea name='content' rows='20' cols='107'></textarea></div><br>
						<div id ='right'><input type='submit' value='Post Blog' onclick='return blogcheck();'></div>
					</h5>
				</form> 
		</div>
	</div>
	<div class="center_module">
		<div class="module">
			<form name="album" action="admin.php" method="post">
				<input type='text' name='name'/>
				<input type='submit' value='add' name="submit"/></div>
			</form>
		</div>
	</div>
</div>
</body>
</html>