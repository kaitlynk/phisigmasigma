
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
						<a href="index.php"><li class="logo">ΦΣΣ</li></a>
						<?php if (isset($_SESSION['logged_user'])) {
							echo "<a href='dashboard.php'><li>HOME</li></a>"; } ?>
						<li>ABOUT</li>
						<?php if (isset($_SESSION['logged_user'])) {
							echo "<li>EVENTS</li> 
							<li>PHOTOS</li>";}
						?>
						<li>CONTACT</li>
					</ul>
				</strong>
					<?php
						if (isset($_SESSION['logged_user'])) {
							echo "<div class='user'>
								Welcome, ".$_SESSION['logged_user']."!<br>
								<a class='logout' href='logout.php'>Logout</a></div>";
						
						}	
						else {
							echo "<button class='login_button' onclick=\"$('.login').slideToggle();\">
							Login
							</button>";
						}
					?>
			</h1>
			<h1 id="ribbon_bottom" class="ribbon">
   				<strong class="ribbon-content">Welcome to Phi Sigma Sigma...</strong>
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