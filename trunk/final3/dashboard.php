<?
include_once('db.inc');
$mysql = new mysqli($host, $username, $password, $database);
if(isset($_POST['vote'])) {
	$mysql->query("INSERT INTO votes(candidateid, voterid) VALUES(".$_POST['choice'].", 1)");
}
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
</head>
<body>
	<div class="header">
		<div class="center">
			<h4>
				ΦΣΣ
			</h4>
			<button class='login_button' onclick=\"$('.login').slideToggle();\">
				Login
			</button>
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
			<div class="title_pink">
				<h3>
					UPCOMING EVENTS
				</h3>
			</div>
	<?
	/*
	$events = $mysql->query("SELECT * FROM events ORDER BY dateadded LIMIT 10");
	while($event = $events->fetch_assoc()) {
		echo '<h3>';
		echo $event['name'];
		echo '</h3>';
		echo '<p>';
		echo $event['date'];
		echo '</p>';
	}
	*/
	?>
		</div>
	</div>
	<div class="center_module">
		<div class="module">
			<h3>
				Vote for Sister of the Month
			</h3>
			<form method="post" action="dashboard.php">
				<?
				$choices = $mysql->query("SELECT username,id FROM users ORDER BY username");
				while($choice = $choices->fetch_assoc()) {
					echo '<p><input type="radio" name="choice" value="'.$choice['id'].'">'.$choice['username'].'</p>';
				}
				?>
				<p>
					<input type="submit" name="vote" class="button"/>
				</p>
			</form>
		</div>
	</div>
</body>
</html>