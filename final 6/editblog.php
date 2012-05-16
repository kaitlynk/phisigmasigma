<?php 
if(!isset($_POST['editid']))
	header('location: index.php');
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
<script type="text/javascript" src="phisigsig.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="phisigsig.js"></script>
</head>
<body>
	<?
	include('header.php');
	?>
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="center_module">
	<div class="module">
			<?php
				$id = $_POST['editid'];
				$blogq = $mysql->query("SELECT* FROM blogposts WHERE id='".$id."'");
				$blog = $blogq->fetch_row();
			?>

			<form name='blog' action='blog.php' method='post'>
				<h4>
					Title
				</h4>
				<p>
					<input type='text' class="text" name='blogtitle' maxlength='50' size='50' value='<?php echo $blog[1]?>'>
				</p>
				<p>
					<input type='hidden' name='author' value='<?php echo $_SESSION['logged_user']; ?>'>
				</p>
					<h4>
							<a href="javascipt:'';" onmousedown = 'return addb();' class='addblogstuff'>B</a>
							<a href="javascipt:'';" onmousedown = 'return addi();' class='addblogstuff'><i>I</i></a>
							<a href="javascipt:'';" onmousedown = 'return addu();' class='addblogstuff'><u>U</u></a>
							<a href="javascipt:'';" onclick = 'return addbr();' class='addblogstuff'>Add Line Break</a>
							<a href="javascipt:'';" onclick = "$('#addblogimg').slideToggle(200);" class='addblogstuff'>Add Image</a>
					</h4>

							<div id = 'addblogimg'>
								<h4>
								URL: <input type = 'text' name = 'imgurl'> &nbsp;
								Size: <input type = 'radio' name='imgsize' value='small' checked>Small &nbsp;
								<input type = 'radio' name='imgsize' value='medium'>Medium &nbsp;
								<input type = 'radio' name='imgsize' value='large'>Large &nbsp; &nbsp;
								<p onclick='return addabi();' class='addlink'>Add Code</p>
								</h4>
							</div>
						
					<input type='hidden' name='editedid' value='<?php echo $blog[0]?>'>
					<input type='hidden' name='action' value='edit'>
					<div id ='center'><textarea name='content'><?php echo $blog[3]?></textarea></div><br>
					<div id ='right'><input type='submit' value='Save Changes' class="button" onclick='return blogvalue("edit");'>
					<input type='submit' value='Delete Blog' onclick='return blogvalue("delete");' class="button"></div>
				
			</form> 
		</div>
		</div>
	</div>
</body>
</html>