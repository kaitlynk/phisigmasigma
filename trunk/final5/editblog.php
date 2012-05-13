<?php session_start();
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
<script type="text/javascript" src="phisigsig.js"></script>
</head>
<body>
	<!-- Welcome, <?php 
					$con = mysql_connect($host,$username,$password);
					
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
						echo "notadmin".$un."!";
					}
					?> -->
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
	<div class="center_module">
	<div class="module">
			<?php
				$id = $_POST['editid'];
				$blogq = mysql_query("SELECT* FROM blogposts WHERE id='".$id."'");
				$blog = mysql_fetch_row($blogq);
			?>

			<form name='blog' action='blog.php' method='post'>
				<h4>
					Title: <input type='text' name='blogtitle' maxlength='50' size='50' value='<?php echo $blog[1]?>'><br><br>
					<input type='hidden' name='author' value='<?php echo $_SESSION['logged_user']; ?>'>
							<a href="javascipt:'';" onmousedown = 'return addb();' class='addblogstuff'>B</a>
							<a href="javascipt:'';" onmousedown = 'return addi();' class='addblogstuff'><i>I</i></a>
							<a href="javascipt:'';" onmousedown = 'return addu();' class='addblogstuff'><u>U</u></a>
							<a href="javascipt:'';" onclick = 'return addbr();' class='addblogstuff'>Add Line Break</a>
							<a href="javascipt:'';" onclick = "$('#addblogimg').slideToggle();" class='addblogstuff'>Add Image</a>

							<div id = 'addblogimg'>
								URL: <input type = 'text' name = 'imgurl'> &nbsp;
								Size: <input type = 'radio' name='imgsize' value='small' checked>Small &nbsp;
								<input type = 'radio' name='imgsize' value='medium'>Medium &nbsp;
								<input type = 'radio' name='imgsize' value='large'>Large &nbsp; &nbsp;
								<p onclick='return addabi();' class='addlink'>Add Code</p>
							</div>
						
					<input type='hidden' name='editedid' value='<?php echo $blog[0]?>'>
					<input type='hidden' name='action' value='edit'>
					<div id ='center'><textarea name='content' rows='20' cols='107'><?php echo $blog[3]?></textarea></div><br>
					<div id ='right'><input type='submit' value='Post Blog' onclick='return blogvalue("edit");'>
					<input type='submit' value='Delete Blog' onclick='return blogvalue("delete");'></div>
				</h4>
			</form> 
		</div>
		</div>
	</div>
</body>
</html>