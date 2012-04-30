
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
			<h3>
				Login
			</h3>
			<p>
				Username
			</p>
			<input type="text" class="text"/>
			<p>
				Password
			</p>
			<input type="text" class="text"/>
		</div>
	</div>
	<div class="ribbon">
		<div class="center">
			<ul>
				<li class="logo">ΦΣΣ</li>
				<li>HOME</li>
				<li>ABOUT</li>
				<li>CONTACT</li>
			</ul>
			<a href="#" class="login_button" onclick="$('.login').slideToggle();">
				Login
			</a>
		</div>
	</div>
	<div class="ribbon_bottom">
		<div class="center">
			<h1>
				Welcome to Phi Sigma Sigma
			</h1>
		</div>
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
				      background: '#f3327f',
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
				}).render().setUser('twitter').start();
				</script>
			</div>
		<h3>
			Recent Events
		</h3>
		<div class="clear"></div>
	</div>
</body>
</html>