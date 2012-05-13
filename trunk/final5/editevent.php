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
				$eventq = mysql_query("SELECT* FROM events WHERE id='".$id."'");
				$event = mysql_fetch_row($eventq);
				$dateq = date_create($event[3]);
				$date = date_format($dateq, 'l, F j, Y @ g:ia');
			?>

			<form name='editevent' action='admin.php' method='post'>
				<h4>
					Title <input type='text' name='eventname' maxlength='50' size='50' value='<?php echo $event[1]?>' class='text'>
				</h4>
				<h4>
					Title <input type='text' name='eventloc' maxlength='100' size='100' value='<?php echo $event[2]?>' class='text'>
				</h4>
				<h4>
					Date <form name = 'dateofe' method = 'POST' action = 'mainck.php'>
						<select name = 'month' onchange = 'return ajaxfunc(this.value);'>
							<option value = '01'>January</option>
							<option value = '02'>February</option>
							<option value = '03'>March</option>
							<option value = '04'>April</option>
							<option value = '05'>May</option>
							<option value = '06'>June</option>
							<option value = '07'>July</option>
							<option value = '08'>August</option>
							<option value = '09'>September</option>
							<option value = '10'>October</option>
							<option value = '11'>November</option>
							<option value = '12'>December</option>
						</select>
						<select name = 'date' id = 'date'>
							<?php
								for ($i = 1; $i < 31; $i++) {
									echo "<option value = '".$i."'>".$i."</option>";
								}
							?>
						</select>
						<input type = 'text' name = 'year' maxlength = '4' size = '4' class='yeartext'>
						<div class='author'> (originally on <?php echo $date; ?>) </div>
					</h4>
						<h4>Time
						<input type = 'text' name = 'hour' maxlength = '2' size = '2' class='timetxt' id = 'hour'>
						:&nbsp;&nbsp;&nbsp;&nbsp;
						<input type = 'text' name = 'mins' maxlength = '2' size = '2' class='timetxt' id = 'mins'>
						<select name = 'ampm'>
							<option value = 'AM'>AM</option>
							<option value = 'PM'>PM</option>
						</select>
						</h4>
						<p>
							<input type='checkbox' name='public' value='public'/> Public Event
						</p>
					<p>
						<input type='hidden' name='editedid' value='<?php echo $event[0]?>'>
					</p>
					<p>
						<input type='hidden' name='edited' value='edited'>
					</p>
					<p>
						<input type='submit' value='Edit Event' class='button'>
					</p>
				</h4>
			</form> 
		</div>
		</div>
	</div>
</body>
</html>