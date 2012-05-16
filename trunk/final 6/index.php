<? 
session_start();
include_once('db.inc');
$mysql = new mysqli($host, $username, $password, $database);
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
<script type="text/javascript" src="notify.js"></script>
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
	include('header.php');
	?>
	<div id="makeMeScrollable">
		<img src="images/home.jpg" alt="image"/>
		<img src="images/home1.png" alt="image" />
		<img src="images/home2.jpg" alt="image"/>
	</div>
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="center">
		<div class="nav_side">
			<ul>
				<li id="current" class="ribbon" onclick="$('.content_bottom').children().fadeOut(100);$('#news').fadeIn(100);$(this).attr('id','current').siblings().removeAttr('id');">
					<strong class="ribbon-content">
					News
					</strong>
				</li>
				<li class="ribbon" onclick="$('.content_bottom').children().fadeOut(100);$('.twitter').fadeIn(100);$(this).attr('id','current').siblings().removeAttr('id');">
					<strong class="ribbon-content">
					Twitter
					</strong>
				</li>
			</ul>
		</div>
		<div class="content_bottom">
			<div id="news">
			<?php
			$allnews = $mysql->query("SELECT title, content,datetime FROM news ORDER BY datetime DESC LIMIT 8");
			while($news = $allnews->fetch_assoc()) {
				echo "<h3>".$news['title']."</h3>";
				echo "<p>".$news['datetime']."</p>";
				echo "<p>".$news['content']."</p>";
			}
			?>
			</div>
			<div class="twitter">
				<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js" type="text/javascript"></script>
				<script type="text/javascript">
				new TWTR.Widget({
				  version: 2,
				  type: 'profile',
				  rpp: 8,
				  interval: 30000,
				  width: 600,
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