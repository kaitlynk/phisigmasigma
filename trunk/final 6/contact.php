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
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="center">
		<img src="images/contact.jpg" alt="contact"/>
		<div class="nav_side">
			<ul>
				<li id="current" class="ribbon">
					<strong class="ribbon-content">
					Contact Us
					</strong>
				</li>
			</ul>
		</div>
		<div class="content_bottom">
			<p>
				If you have any questions, comments, or concerns, please do not hesitate to reach out to us! We would
				love to hear from you!
			</p>
			<h3>
				Email us at:
			</h3>
			<p>
				Mary Lopez, mel239@cornell.edu
			</p>
			<p>
				Renee Britton, rmb282@cornell.edu
			</p>
			<h3>
				Send us a letter at:
			</h3>
			<p>
				Phi Sigma Sigma <br/>
				14 South Avenue <br/>
				Ithaca, NY 14850
			</p>
		</div>
		<div class="clear"></div>
	</div>
</body>
</html>